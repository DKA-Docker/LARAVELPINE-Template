<?php

namespace App\Helpers\Exceptions;

use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Database\QueryException;

class HelpersExceptionsHttpCode
{
    /** @var array<int, int> */
    private const MAP = [
        // ===== CONFLICT (409) =====
        1022 => 409, 1062 => 409, 1586 => 409,
        1215 => 409, 1451 => 409, 1452 => 409, 1213 => 409,
        // ===== UNPROCESSABLE ENTITY (422) =====
        1048 => 422, 1364 => 422, 1366 => 422, 1264 => 422,
        1265 => 422, 1292 => 422, 1406 => 422, 3819 => 422,
        4025 => 422,
        // ===== SERVICE UNAVAILABLE (503) =====
        1205 => 503, 1045 => 503, 1142 => 503,
        // ===== BAD REQUEST (400) =====
        1064 => 400, 1052 => 400, 1690 => 400,
        // ===== NOT FOUND (404) =====
        1146 => 404, 1054 => 404,
    ];

    public function fromSQLError(QueryException $e): array
    {
        // PostgreSQL menggunakan SQLSTATE di errorInfo[0], MySQL menggunakan error code di errorInfo[1]
        $sqlState = $e->errorInfo[0] ?? null;
        $sqlCode = (int)($e->errorInfo[1] ?? 0);
        $message = $e->getMessage();
        $msgLower = strtolower($message);

        // 1) Hard map berdasarkan SQL Code (MySQL)
        $httpCode = self::MAP[$sqlCode] ?? null;

        // 2) Mapping berdasarkan SQLSTATE (PostgreSQL & Standar SQL)
        if ($httpCode === null) {
            $httpCode = match ($sqlState) {
                '23505' => 409, // Unique violation
                '23503' => 409, // Foreign key violation
                '23502' => 422, // Not null violation
                '23514' => 422, // Check constraint violation
                '22001' => 422, // String data right truncation (Too long)
                default => null,
            };
        }

        // 3) Heuristik jika masih null
        if ($httpCode === null) {
            $httpCode = match (true) {
                str_contains($msgLower, 'duplicate') || str_contains($msgLower, 'unique') => 409,
                str_contains($msgLower, 'null') || str_contains($msgLower, 'constraint') => 422,
                str_contains($msgLower, 'syntax') => 400,
                default => 500,
            };
        }

        // 4) Ekstraksi Pesan Spesifik (Sangat penting untuk PostgreSQL)
        $userFriendlyMsg = $this->extractDetails($message, $httpCode);

        return [
            'status' => false,
            'code'  => $httpCode,
            'msg' => $userFriendlyMsg,
            'error' => [
                'code' => $sqlCode ?: $sqlState,
                'msg'  => $message,
            ],
        ];
    }

    private function extractDetails(string $rawMsg, int $httpCode): string
    {
        $msgLower = strtolower($rawMsg);

        // --- Kasus DUPLIKAT (Conflict 409) ---
        if ($httpCode === 409) {
            // PostgreSQL: DETAIL: Key (email)=(test@gmail.com) already exists.
            if (preg_match('/Key \((.*?)\)=\((.*?)\) already exists/', $rawMsg, $matches)) {
                return "Data " . $matches[1] . " '" . $matches[2] . "' sudah terdaftar.";
            }
            // MySQL: Duplicate entry 'test@gmail.com' for key '...'
            if (preg_match("/Duplicate entry '(.*?)' for key/", $rawMsg, $matches)) {
                return "Data '" . $matches[1] . "' sudah terdaftar dalam sistem.";
            }
            return "Terjadi duplikasi data pada sistem.";
        }

        // --- Kasus KOSONG / NOT NULL (Unprocessable 422) ---
        if ($httpCode === 422) {
            // PostgreSQL: null value in column "name" violates not-null constraint
            if (preg_match('/column "(.*?)" violates not-null constraint/', $rawMsg, $matches)) {
                return "Kolom '" . $matches[1] . "' tidak boleh kosong.";
            }
            // MySQL: Column 'name' cannot be null
            if (preg_match("/Column '(.*?)' cannot be null/", $rawMsg, $matches)) {
                return "Kolom '" . $matches[1] . "' wajib diisi.";
            }
            return "Input data tidak valid atau ada kolom yang kosong.";
        }

        // --- Kasus Lainnya ---
        return match ($httpCode) {
            404 => "Data atau tabel tidak ditemukan.",
            400 => "Permintaan data tidak valid (Syntax Error).",
            503 => "Koneksi database sibuk atau akses ditolak.",
            default => "Terjadi kesalahan internal pada database."
        };
    }
}

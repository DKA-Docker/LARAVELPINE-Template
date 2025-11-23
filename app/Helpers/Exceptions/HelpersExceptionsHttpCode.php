<?php
namespace App\Helpers\Exceptions;

use Illuminate\Database\QueryException;

class HelpersExceptionsHttpCode
{
    /**
     * @phpstan-type SqlError array{code:int, msg:string}
     * @phpstan-type HttpError array{code:int, error:SqlError}
     */

    /** @var array<int, int> */
    private const MAP = [
        // ===== CONFLICT (409) - bentrok data / constraint =====
        1022 => 409, // Can't write; duplicate key
        1062 => 409, // Duplicate entry
        1586 => 409, // Duplicate index
        1215 => 409, // Cannot add foreign key constraint
        1216 => 409, // Cannot add or update child row: FK fails (varian lama)
        1451 => 409, // Cannot delete/update parent row: FK constraint fails
        1452 => 409, // Cannot add or update child row: FK constraint fails
        1213 => 409, // Deadlock found when trying to get lock
        // ===== UNPROCESSABLE ENTITY (422) =====
        1048 => 422, // Column cannot be null
        1364 => 422, // Field doesn't have a default value
        1366 => 422, // Incorrect/truncated value
        1264 => 422, // Out of range value
        1265 => 422, // Data truncated
        1292 => 422, // Incorrect datetime value
        1406 => 422, // Data too long
        3819 => 422, // CHECK constraint violated (MySQL 8+)
        3822 => 422, // Validation error for generated column
        4025 => 422, // CONSTRAINT CHECK failed
        // ===== SERVICE UNAVAILABLE (503) =====
        1205 => 503, // Lock wait timeout exceeded
        // ===== BAD REQUEST (400) =====
        1064 => 400, // SQL syntax error
        1052 => 400, // Column ambiguous
        1066 => 400, // Not unique table/alias
        1111 => 400, // Invalid use of group function
        1140 => 400, // Aggregated query without GROUP BY
        1141 => 400, // No such grant defined
        1148 => 400, // Command not allowed
        1690 => 400, // Division by 0
        1365 => 400, // Division by 0 (variant)
        // ===== NOT FOUND (404) =====
        1146 => 404, // Table doesn't exist
        1054 => 404, // Unknown column
        1051 => 404, // Unknown table
        1049 => 404, // Unknown database
        // ===== AUTH/PERM (dipetakan aman ke 503) =====
        1045 => 503, // Access denied for user
        1142 => 503, // Command denied
        1143 => 503, // Select denied
        // ===== INSUFFICIENT STORAGE (507) =====
        1114 => 507, // Table is full
        1021 => 507, // Disk full / write failed
    ];

    /**
     * Mapping dari SQL Error Code ke HTTP Status (dengan heuristik switch-case).
     *
     * @return array{code:int, error:array{code:int, msg:string}}
     */
    public function fromSQLError(QueryException $e): array
    {
        $sqlCode = (int)($e->errorInfo[1] ?? 0);
        $message = $e->getMessage();
        // 1) Hard map dulu
        $httpCode = self::MAP[$sqlCode] ?? null;
        // 2) Heuristik jika belum terpetakan (switch-case style)
        if ($httpCode === null) {
            $msgLower = strtolower($message);
            $isConflictLike = in_array($sqlCode, [1215, 1216, 1217, 1218, 1219, 1220, 1213], true);
            $httpCode = match (true) {
                $isConflictLike
                || str_contains($msgLower, 'duplicate entry')
                || str_contains($msgLower, 'foreign key') => 409,
                str_contains($msgLower, 'cannot be null')
                || str_contains($msgLower, 'data too long')
                || str_contains($msgLower, 'out of range')
                || str_contains($msgLower, 'truncated')
                || str_contains($msgLower, 'incorrect')
                || str_contains($msgLower, 'check constraint') => 422,
                str_contains($msgLower, 'unknown column')
                || str_contains($msgLower, 'unknown table')
                || str_contains($msgLower, 'unknown database') => 404,
                str_contains($msgLower, 'syntax')
                || str_contains($msgLower, 'ambiguous')
                || str_contains($msgLower, 'not unique table/alias')
                || str_contains($msgLower, 'division by 0') => 400,
                $sqlCode === 1205 || str_contains($msgLower, 'lock wait timeout') => 503,
                $sqlCode === 1213 || str_contains($msgLower, 'deadlock') => 409,
                str_contains($msgLower, 'access denied')
                || str_contains($msgLower, 'denied to user')
                || str_contains($msgLower, 'not allowed') => 503,
                str_contains($msgLower, 'table is full')
                || str_contains($msgLower, 'disk full')
                || str_contains($msgLower, 'no space left') => 507,
                default => 500,
            };
        }

        return [
            'status' => false,
            'code'  => $httpCode,
            'msg' => "Database Internal Error",
            'error' => [
                'code' => $sqlCode,
                'msg'  => $message,
            ],
        ];
    }
}

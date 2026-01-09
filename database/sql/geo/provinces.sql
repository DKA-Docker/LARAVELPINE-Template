-- 1. Pengaturan Encoding (Opsional di Postgres, biasanya UTF8 secara default)
SET client_encoding = 'UTF8';

-- 4. Memasukkan Data
-- PostgreSQL menggunakan BEGIN dan COMMIT untuk transaksi
BEGIN;

INSERT INTO "data_geos_provinces" ("id", "name", "status") VALUES (11, 'ACEH', false);
INSERT INTO "data_geos_provinces" ("id", "name", "status") VALUES (12, 'SUMATERA UTARA', false);
INSERT INTO "data_geos_provinces" ("id", "name", "status") VALUES (13, 'SUMATERA BARAT', false);
INSERT INTO "data_geos_provinces" ("id", "name", "status") VALUES (14, 'RIAU', false);
INSERT INTO "data_geos_provinces" ("id", "name", "status") VALUES (15, 'JAMBI', false);
INSERT INTO "data_geos_provinces" ("id", "name", "status") VALUES (16, 'SUMATERA SELATAN', false);
INSERT INTO "data_geos_provinces" ("id", "name", "status") VALUES (17, 'BENGKULU', false);
INSERT INTO "data_geos_provinces" ("id", "name", "status") VALUES (18, 'LAMPUNG', false);
INSERT INTO "data_geos_provinces" ("id", "name", "status") VALUES (19, 'KEPULAUAN BANGKA BELITUNG', false);
INSERT INTO "data_geos_provinces" ("id", "name", "status") VALUES (21, 'KEPULAUAN RIAU', false);
INSERT INTO "data_geos_provinces" ("id", "name", "status") VALUES (31, 'DKI JAKARTA', false);
INSERT INTO "data_geos_provinces" ("id", "name", "status") VALUES (32, 'JAWA BARAT', false);
INSERT INTO "data_geos_provinces" ("id", "name", "status") VALUES (33, 'JAWA TENGAH', false);
INSERT INTO "data_geos_provinces" ("id", "name", "status") VALUES (34, 'DAERAH ISTIMEWA YOGYAKARTA', false);
INSERT INTO "data_geos_provinces" ("id", "name", "status") VALUES (35, 'JAWA TIMUR', false);
INSERT INTO "data_geos_provinces" ("id", "name", "status") VALUES (36, 'BANTEN', false);
INSERT INTO "data_geos_provinces" ("id", "name", "status") VALUES (51, 'BALI', false);
INSERT INTO "data_geos_provinces" ("id", "name", "status") VALUES (52, 'NUSA TENGGARA BARAT', false);
INSERT INTO "data_geos_provinces" ("id", "name", "status") VALUES (53, 'NUSA TENGGARA TIMUR', false);
INSERT INTO "data_geos_provinces" ("id", "name", "status") VALUES (61, 'KALIMANTAN BARAT', false);
INSERT INTO "data_geos_provinces" ("id", "name", "status") VALUES (62, 'KALIMANTAN TENGAH', false);
INSERT INTO "data_geos_provinces" ("id", "name", "status") VALUES (63, 'KALIMANTAN SELATAN', false);
INSERT INTO "data_geos_provinces" ("id", "name", "status") VALUES (64, 'KALIMANTAN TIMUR', false);
INSERT INTO "data_geos_provinces" ("id", "name", "status") VALUES (65, 'KALIMANTAN UTARA', false);
INSERT INTO "data_geos_provinces" ("id", "name", "status") VALUES (71, 'SULAWESI UTARA', true);
INSERT INTO "data_geos_provinces" ("id", "name", "status") VALUES (72, 'SULAWESI TENGAH', true);
INSERT INTO "data_geos_provinces" ("id", "name", "status") VALUES (73, 'SULAWESI SELATAN', true);
INSERT INTO "data_geos_provinces" ("id", "name", "status") VALUES (74, 'SULAWESI TENGGARA', true);
INSERT INTO "data_geos_provinces" ("id", "name", "status") VALUES (75, 'GORONTALO', true);
INSERT INTO "data_geos_provinces" ("id", "name", "status") VALUES (76, 'SULAWESI BARAT', true);
INSERT INTO "data_geos_provinces" ("id", "name", "status") VALUES (81, 'MALUKU', false);
INSERT INTO "data_geos_provinces" ("id", "name", "status") VALUES (82, 'MALUKU UTARA', false);
INSERT INTO "data_geos_provinces" ("id", "name", "status") VALUES (91, 'PAPUA', false);
INSERT INTO "data_geos_provinces" ("id", "name", "status") VALUES (92, 'PAPUA BARAT', false);

COMMIT;

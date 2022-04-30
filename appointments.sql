-- SQLite
DROP TABLE IF EXISTS "Appointments";
CREATE TABLE "Appointments" (
    "Id" INTEGER NOT NULL CONSTRAINT "PK_Appointments" PRIMARY KEY AUTOINCREMENT,
    "AppointmentNumber" TEXT NOT NULL,
    "Firstname" TEXT NOT NULL,
    "Lastname" TEXT NOT NULL,
    "EmailAddress" TEXT NOT NULL,
    "AppointmentDate" TEXT NOT NULL,
    "Notes" TEXT NULL);
<?php

namespace Database\Seeders;

use App\Models\Assignment;
use App\Models\MataKuliah;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $dosen = User::updateOrCreate(
            ['email' => 'budi.santoso@celoe.test'],
            [
                'name' => 'Dr. Ir. Budi Santoso, M.T.',
                'password' => Hash::make('password123'),
                'role' => 'dosen',
                'nomor_induk' => '198001012005041001',
            ]
        );

        $mahasiswa = User::updateOrCreate(
            ['email' => 'raihan.arifinza@celoe.test'],
            [
                'name' => 'Ahmad Raihan Arifinza',
                'password' => Hash::make('password123'),
                'role' => 'mahasiswa',
                'nomor_induk' => '1302260143',
            ]
        );

        $course = MataKuliah::updateOrCreate(
            ['kode_mk' => 'PAW'],
            [
                'nama_mk' => 'Pengembangan Aplikasi Website',
                'deskripsi' => 'Mempelajari pengembangan aplikasi web berbasis Laravel: routing, controller, model Eloquent, migration, dan CRUD.',
                'sks' => 3,
                'semester' => 'Ganjil 2026/2027',
                'dosen_id' => $dosen->id,
            ]
        );

        $course->students()->syncWithoutDetaching([
            $mahasiswa->id => ['status' => 'approved'],
        ]);

        $assignment = Assignment::updateOrCreate(
            ['course_id' => $course->id, 'judul' => 'Tugas 01 - Bikin Sistem Kasir pake Laravel'],
            [
                'deskripsi' => 'Buat sistem kasir sederhana menggunakan Laravel dengan fitur CRUD produk dan transaksi.',
                'deadline' => '2026-10-22 23:59:00',
            ]
        );

        $assignment->submissions()->updateOrCreate(
            ['user_id' => $mahasiswa->id],
            [
                'jawaban' => 'Sistem kasir sudah dibuat: CRUD produk, keranjang, dan riwayat transaksi.',
                'submitted_at' => '2026-10-21 20:00:00',
            ]
        );
    }
}
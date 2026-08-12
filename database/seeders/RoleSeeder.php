<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'Super Admin', 'Ketua', 'Bendahara', 'Sekretaris',
            'Koordinator Divisi', 'Anggota', 'Auditor',
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Akun contoh untuk masing-masing role (password: password123)
        $akun = [
            ['nama' => 'Super Admin', 'email' => 'admin@sinergi.org', 'role' => 'Super Admin'],
            ['nama' => 'Budi Ketua', 'email' => 'ketua@sinergi.org', 'role' => 'Ketua'],
            ['nama' => 'Siti Bendahara', 'email' => 'bendahara@sinergi.org', 'role' => 'Bendahara'],
            ['nama' => 'Andi Sekretaris', 'email' => 'sekretaris@sinergi.org', 'role' => 'Sekretaris'],
            ['nama' => 'Dewi Anggota', 'email' => 'anggota@sinergi.org', 'role' => 'Anggota'],
            ['nama' => 'Rudi Auditor', 'email' => 'auditor@sinergi.org', 'role' => 'Auditor'],
        ];

        foreach ($akun as $index => $item) {
            $user = User::firstOrCreate(
                ['email' => $item['email']],
                [
                    'nama' => $item['nama'],
                    'password' => Hash::make('password123'),
                    'nomor_anggota' => 'A-' . str_pad((string) ($index + 1), 4, '0', STR_PAD_LEFT),
                    'jabatan' => $item['role'],
                    'status_keanggotaan' => 'aktif',
                    'tanggal_bergabung' => now(),
                ]
            );
            $user->assignRole($item['role']);
        }
    }
}
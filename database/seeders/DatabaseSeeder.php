<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'Super Admin',
            'Ketua',
            'Bendahara',
            'Sekretaris',
            'Koordinator Divisi',
            'Anggota',
            'Auditor',
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate([
                'name' => $role,
                'guard_name' => 'web',
            ]);
        }

        $users = [
            [
                'nama' => 'Super Administrator',
                'email' => 'admin@sinergi.local',
                'role' => 'Super Admin',
                'jabatan' => 'Administrator',
                'divisi' => 'Sistem',
            ],
            [
                'nama' => 'Ketua',
                'email' => 'ketua@sinergi.local',
                'role' => 'Ketua',
                'jabatan' => 'Ketua',
                'divisi' => 'Pengurus',
            ],
            [
                'nama' => 'Bendahara',
                'email' => 'bendahara@sinergi.local',
                'role' => 'Bendahara',
                'jabatan' => 'Bendahara',
                'divisi' => 'Keuangan',
            ],
            [
                'nama' => 'Sekretaris',
                'email' => 'sekretaris@sinergi.local',
                'role' => 'Sekretaris',
                'jabatan' => 'Sekretaris',
                'divisi' => 'Administrasi',
            ],
            [
                'nama' => 'Koordinator',
                'email' => 'koordinator@sinergi.local',
                'role' => 'Koordinator Divisi',
                'jabatan' => 'Koordinator',
                'divisi' => 'Kegiatan',
            ],
            [
                'nama' => 'Anggota',
                'email' => 'anggota@sinergi.local',
                'role' => 'Anggota',
                'jabatan' => 'Anggota',
                'divisi' => 'Umum',
            ],
            [
                'nama' => 'Auditor',
                'email' => 'auditor@sinergi.local',
                'role' => 'Auditor',
                'jabatan' => 'Auditor',
                'divisi' => 'Pengawasan',
            ],
        ];

        foreach ($users as $index => $data) {

            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'nama' => $data['nama'],
                    'password' => Hash::make('password'),
                    'nomor_anggota' => 'AGT' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                    'jabatan' => $data['jabatan'],
                    'divisi' => $data['divisi'],
                    'status_keanggotaan' => 'aktif',
                    'tanggal_bergabung' => now(),
                ]
            );

            $user->syncRoles([$data['role']]);
        }
    }
}
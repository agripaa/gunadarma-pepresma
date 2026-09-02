<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        DB::transaction(function () {
            $now = now();

            DB::table('roles')->updateOrInsert(['id' => 1], [
                'name_role' => 'Superadmin',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            DB::table('roles')->updateOrInsert(['id' => 2], [
                'name_role' => 'Admin',
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $accounts = [
                [
                    'username' => 'superadmin',
                    'email' => 'superadmin@gunadarma.ac.id',
                    'password' => '$2y$10$fH9Od0pNPO54zg8FDOz9Ie2nsDQe8exZQpLx50ew6YIEsz8KpsxtG',
                    'role' => 1,
                ],
                [
                    'username' => 'admin',
                    'email' => 'admin@gunadarma.ac.id',
                    'password' => '$2y$10$UVQltCw9AuzBMiKHOwJ8Ke80ioC9UCXqNXyNdASf5Z95MJECAKFpS',
                    'role' => 2,
                ],
            ];

            foreach ($accounts as $account) {
                $user = DB::table('users')->where('email', $account['email']);

                if ($user->exists()) {
                    $user->update($account + ['updated_at' => $now]);
                } else {
                    DB::table('users')->insert($account + [
                        'uuid' => (string) Str::uuid(),
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]);
                }
            }

            if (! DB::table('contact')->exists()) {
                DB::table('contact')->insert([
                    'alamat' => 'Jl. Margonda Raya No. 100, Kec. Pondok Cina, Kel. Beji, Kota Depok, Jawa Barat - Indonesia, 16424.',
                    'no_telepon' => '21-78881112',
                    'email' => 'kemahasiswaan@gunadarma.ac.id',
                    'map_embed' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d76660.47909422366!2d106.7569759486328!3d-6.3685213999999934!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69ed01b68548ad%3A0x89aea3afc2b2e77d!2sUniversitas%20Gunadarma%20Kampus%20D!5e1!3m2!1sid!2sus!4v1788331515031!5m2!1sid!2sus',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        });
    }


    public function down(): void
    {
    }
};

<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    public function run()
    {
        Admin::updateOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Administrator Utama',
                'password' => Hash::make('admin123'),
                'remember_token' => Str::random(10),
            ]
        );

        $this->command->info('========================================');
        $this->command->info('AKUN ADMIN BERHASIL DIBUAT');
        $this->command->info('Username: admin');
        $this->command->info('Password: Admin12345');
        $this->command->warn('Harap segera ubah password setelah login pertama!');
        $this->command->info('========================================');
    }
}

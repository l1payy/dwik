<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User Sekretaris
        \App\Models\User::create([
            'name' => 'Sekretaris BPBD',
            'email' => 'sekretaris@bpbd.binjai.id',
            'password' => bcrypt('password123'),
            'role' => 'sekretaris',
        ]);

        // User Pimpinan
        \App\Models\User::create([
            'name' => 'Pimpinan BPBD',
            'email' => 'pimpinan@bpbd.binjai.id',
            'password' => bcrypt('password123'),
            'role' => 'pimpinan',
        ]);
    }
}

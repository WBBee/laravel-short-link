<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SeedAccount extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array_user = [
            [
                'name' => 'admin',
                'email' => 'email@admin.com',
                'password' => Hash::make('admin123'),
            ]
        ];

        User::insert($array_user);
    }
}

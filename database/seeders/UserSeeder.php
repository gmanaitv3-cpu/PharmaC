<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Jamal Admin',
                'password' => Hash::make('password'),
            ]
        );

        $user->forceFill([
            'name' => 'Jamal Admin',
            'password' => Hash::make('password'),
        ])->save();

        if (!$user->hasRole('super-admin')) {
            $user->assignRole('super-admin');
        }
    }
}

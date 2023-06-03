<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@mail.com',
                'password' => 'power@123',
            ]
        ];

        foreach ($users as $userData) {
            $password = $userData['password'];
            $userData = User::factory()->make($userData)->toArray();
            $userData['password'] = \Hash::make($password);

            \dump("E-mail: {$userData['email']}");
            \dump("Password: {$password}");

            $user = User::firstOrCreate(
                [
                    'email' => $userData['email'],
                ],
                \collect($userData)->except([
                    'id',
                    'created_at',
                ])->toArray(),
            );

            // $user->roleSync...
        }
    }
}

<?php
namespace Milano\User\Database\Seeds;
use Milano\User\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        foreach (User::$defaultUsers as $user){
            User::firstOrCreate(
                ['email' => $user['email']]
                ,[
                "email" => $user['email'],
                "name" => $user['name'],
                "username" => $user['username'],
                "password" => bcrypt($user['password'])
            ])->assignRole($user['role'])->markEmailAsVerified();
        }
    }
}

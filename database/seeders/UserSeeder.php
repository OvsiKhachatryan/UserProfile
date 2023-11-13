<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $users = [
            ['name' => 'Stephan', 'surname' => 'Vries', 'age' => '30', 'city' => 'Berlin', 'email' => 'stephan-v@gmail.com', 'password' => bcrypt('user1234')],
            ['name' => 'John', 'surname' => 'Doe', 'age' => '22', 'city' => 'London', 'email' => 'johndoe@gmail.com', 'password' => bcrypt('user1234')],
            ['name' => 'David', 'surname' => 'Jones', 'age' => '25', 'city' => 'Los Angeles', 'email' => 'davis@gmail.com', 'password' => bcrypt('user1234')],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}

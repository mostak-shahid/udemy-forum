<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\User::create([
        	'name' => 'System Admin',
        	'avatar' => asset('system-admin.png'),
        	'admin' => 1,
        	'email' => 'mostak.shahid@gmail.com',
        	'password' => bcrypt('123456789'),
        ]);
    }
}

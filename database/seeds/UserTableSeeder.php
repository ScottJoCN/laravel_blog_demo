<?php

use Illuminate\Database\Seeder;
use App\User;
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::create([
        	'email' => 'admin@shiyanlou.com',
        	'password' => Hash::make('shiyanlou'),
        	'nickname' => 'admin',
        	'is_admin' => 1,
        ]);
    }
}

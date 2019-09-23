<?php

use Illuminate\Database\Seeder;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        User::create(['name' => 'Administrador', 'email' => 'i9tech@hotmail.com', 'password' => bcrypt('I9Solutions')]);
    }
}

<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Grupo;

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
        $grupo = Grupo::create(['nome' => 'Greupo inicial']);
        User::create(['name' => 'Administrador', 'permissao' => 'Master', 'grupo_id' => $grupo->id, 'email' => 'i9tech@hotmail.com', 'password' => bcrypt('I9Solutions')]);
    }
}

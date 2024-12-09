<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'permission_level' => 2,
            'password' => Hash::make('123123123'),
        ]);

        User::factory()->create([
            'name' => 'Eduardo Gois',
            'email' => 'eduardo@gmail.com',
            'permission_level' => 1,
            'password' => Hash::make('password'),
            'tipo' => 'Neurocirurgiao',
            'foto' => 'https://blog.noxsaude.com.br/wp-content/uploads/2024/06/Design-sem-nome-4-800x542.png'
        ]);

        User::factory()->create([
            'name' => 'Gustavo Andrade',
            'email' => 'gustavo@gmail.com',
            'permission_level' => 1,
            'password' => Hash::make('password'),
            'tipo' => 'Medico Generalista',
            'foto' => 'https://fly.metroimg.com/upload/q_85,w_700/https://uploads.metroimg.com/wp-content/uploads/2022/06/21140456/FOTO-1-4-1.jpeg'
        ]);
        User::factory()->create([
            'name' => 'Simone Dantas',
            'email' => 'simone@gmail.com',
            'permission_level' => 1,
            'password' => Hash::make('password'),
            'tipo' => 'Geriatria',
            'foto' => 'https://yata.s3-object.locaweb.com.br/ee063882fd4fced76f625d5b8c47bd493464df2a5b04cc2cb0f2c109c15c9b79'
        ]);

        User::factory()->create([
            'name' => 'Paula Vieira',
            'email' => 'paula@gmail.com',
            'permission_level' => 1,
            'password' => Hash::make('password'),
            'tipo' => 'Médica Oncologica',
            'foto' => 'https://bradescosaudeconvenio.com.br/wp-content/uploads/2024/08/tratamentos-oncologicos-no-hospital-sirio-libanes.jpg'
        ]);

        User::factory()->create([
            'name' => 'User test',
            'email' => 'test@gmail.com',
            'permission_level' => 0,
            'password' => Hash::make('password'),
        ]);
    }
}

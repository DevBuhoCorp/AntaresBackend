<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        factory(App\User::class)->create([
            'name' => 'kevin',
            'email' => 'kebryansg@gmail.com',
            'password' => password_hash('kebryansg', PASSWORD_BCRYPT)
        ]);
        factory(App\User::class)->create([
            'name' => 'ronald',
            'email' => 'ronald.chica.2ai@gmail.com',
            'password' => password_hash('ronald', PASSWORD_BCRYPT)
        ]);

        factory(App\User::class)->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => password_hash('admin', PASSWORD_BCRYPT)
        ]);
    }
}
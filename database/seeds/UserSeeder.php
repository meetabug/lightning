<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->create([
            'name' => 'Lucas Yang',
            'email' => 'admin@example.com',
            'description' => '夜空中的小星星，也會閃耀著光芒~~',
        ]);

        factory(User::class, 9)->create();

    }
}

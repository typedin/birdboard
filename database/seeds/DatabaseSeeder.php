<?php

use App\Project;
use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = factory(User::class)->create([
            "name" => "typedin",
            "email" => "typedin@example.com",
            "password" => Hash::make("secret"),
            "id" => 1
        ]);
        Auth::login($user);

        factory(Project::class, 5)->create(['owner_id' => 1 ]);

        factory(Project::class, 5)->create();
    }
}

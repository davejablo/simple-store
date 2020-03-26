<?php

use Illuminate\Database\Seeder;

class UserProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 1)->create()->each(function ($user) {
            $user->profile()->save(factory(App\UserProfile::class)->make());
            $user->roles()->attach((1));
        });

        factory(App\User::class, 5)->create()->each(function ($user) {
            $user->profile()->save(factory(App\UserProfile::class)->make());
            $user->roles()->attach(2);
        });
    }
}
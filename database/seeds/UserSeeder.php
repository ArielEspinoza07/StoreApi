<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Models\User::create(
            array(
                'name'      =>  'my_user',
                'email'     =>  'my_user',
                'password'  => Hash::make('my_password')
            )
        );
    }
}

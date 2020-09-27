<?php

use App\User;
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
        $user=User::create([
           'first_name'=>'ali',
           'last_name'=>'yousef',
            'email'=>'ali@yahoo',
            'password'=>bcrypt('123123123')
        ]);//end of creation
        $user->attachRole('super_admin');
    }// end of run
}//end of seeder

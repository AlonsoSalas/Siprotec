<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 08/06/15
 * Time: 12:54 AM
 */

class UserTableSeeder extends \Illuminate\Database\Seeder{

    public function run(){
        \DB::table('users')->insert(array (
            'nombre' => 'Alonso',
            'email' => 'ALonso@e.a',
            'password' => \Hash::make('secret')
        ));
    }
}
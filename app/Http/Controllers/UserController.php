<?php namespace siprotec\Http\Controllers;


use Illuminate\Routing\Controller;

class UserController extends Controller{

    public function getIndex(){
       $result = \DB::table('users')->get();

        dd($result);


           return $result;
    }
}
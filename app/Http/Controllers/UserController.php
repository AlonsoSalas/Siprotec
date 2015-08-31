<?php namespace siprotec\Http\Controllers;


use Illuminate\Routing\Controller;

class UserController extends Controller{

    public function getIndex(){
       $result = \DB::table('Usuario')->get();

        dd($result);


           return $result;
    }
}
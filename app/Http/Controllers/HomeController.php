<?php namespace siprotec\Http\Controllers;

use siprotec\Proveedor;
use siprotec\ProyectEspe;
use siprotec\Proyecto;
use siprotec\User;
use siprotec\Area;
use Request;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function indexpro()
	{
        $proyectos = Proyecto::name(Request::input('name'))->orderBy('id_proyecto','ASC')->paginate(10);
        $ProyectEspe = ProyectEspe::paginate(100);
        $especialistas = User::paginate(100);
        $proveedores = Proveedor::paginate(1000);
        return view('proyectos', compact('proyectos','ProyectEspe','especialistas','proveedores'));
	}

}

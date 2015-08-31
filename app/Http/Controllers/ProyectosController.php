<?php namespace siprotec\Http\Controllers;

use siprotec\Proveedor;
use siprotec\ProyectEspe;
use siprotec\Proyecto;
use siprotec\User;
use siprotec\Area;
use Symfony\Component\HttpFoundation\Request;

class ProyectosController extends Controller {


    public function index(Request $request)
    {
        $proyectos = Proyecto::paginate(100);
        $ProyectEspe = ProyectEspe::paginate(100);
        $especialistas = User::paginate(100);
        $proveedores = Proveedor::paginate(1000);
        return view('proyectos', compact('proyectos','ProyectEspe','especialistas','proveedores'));

    }

    public function newmeta()
    {
        return view('newmeta');
    }

    public function newincidencia()
    {
        $areas = Area::paginate(25)->lists('nombre');
        $especialistas = User::paginate(25);
        return view('newincidencia',compact('areas','especialistas'));
    }

    public function Proyectos2()
    {
        $proyectos = Proyecto::paginate();
        $ProyectEspe = ProyectEspe::paginate(100);
        $especialistas = User::paginate(100);
        $proveedores =  Proveedor::paginate(1000);

        return view('proyectos2',compact('proyectos','ProyectEspe','especialistas', 'proveedores'));
    }







}
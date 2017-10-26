<?php namespace siprotec\Http\Controllers;

use siprotec\Proveedor;
use siprotec\ProyectEspe;
use siprotec\Proyecto;
use siprotec\User;
use siprotec\Area;
use Request;

class ProyectosController extends Controller {


    public function indexpro(Request $request)
    {
        $proyectos = Proyecto::name(Request::input('name'))->orderBy('id_proyecto','desc')->paginate(10);
        $ProyectEspe = ProyectEspe::paginate(100);
        $especialistas = User::paginate(100);
        $proveedores = Proveedor::paginate(1000);
        return view('proyectos', compact('proyectos','ProyectEspe','especialistas','proveedores'));

    }

    public function proyectosEspe()
    {
        $proyectos= \DB::table('Proyecto')->orderBy('especialista', 'desc')->paginate(10);
        $ProyectEspe = ProyectEspe::paginate(100);
        $especialistas = User::paginate(100);
        $proveedores = Proveedor::paginate(1000);
        return view('proyectos', compact('proyectos','ProyectEspe','especialistas','proveedores'));

    }

    public function proyectosStatus()
    {
        $proyectos= \DB::table('Proyecto')->orderBy('id_enum_estatus', 'desc')->paginate(10);
        $ProyectEspe = ProyectEspe::paginate(100);
        $especialistas = User::paginate(100);
        $proveedores = Proveedor::paginate(1000);
        return view('proyectos', compact('proyectos','ProyectEspe','especialistas','proveedores'));

    }
    public function proyectosFecha()
    {
        $proyectos = \DB::table('Proyecto')->orderBy('fecha_ingreso', 'desc')->paginate(10);
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
        $areas = Area::paginate(100);
        $especialistas = User::paginate(1000000);
        return view('newincidencia',compact('areas','especialistas'));
    }

    public function Proyectos2()
    {
        $proyectos = Proyecto::paginate(16);
        $ProyectEspe = ProyectEspe::paginate(100);
        $especialistas = User::paginate(100);
        $proveedores =  Proveedor::paginate(1000);

        return view('proyectos2',compact('proyectos','ProyectEspe','especialistas', 'proveedores'));
    }







}

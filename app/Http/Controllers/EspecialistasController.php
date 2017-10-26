<?php namespace siprotec\Http\Controllers;

use siprotec\Http\Requests;
use siprotec\Http\Controllers\Controller;
use Illuminate\Http\Request;
use siprotec\Proveedor;
use siprotec\User;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Redirect;
use siprotec\Http\Controllers\App;
use siprotec\Area;

class EspecialistasController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function internos()
    {
        $areas = Area::paginate(100);
        $especialistas = User::Paginate(100000);
        return view('EspeIn', compact('especialistas','areas'));


    }
    public function editarespein($id)
    {
        $especialista = User::find($id);
        $areas = Area::paginate(100);
        $cont = "Presidencia Ejecutiva";
        foreach($areas as $a){
            if($a->nombre == $especialista->id_area){
                $cont=$a->nombre;
            }
        }

        return view('EditEspeIn', compact('especialista','areas','cont'));
    }

    public function updateespein($id, Request $request)
    {
        $especialista = User::findOrFail($id);
        $especialista->fill($request->all());
        $areas = Area::paginate(100);
        foreach($areas as $a){
            if($a->nombre == $request->get('id_area')){
                $especialista->id_area=$a->nombre;
            }
        }
        $especialista->save();
        $especialistas = User::Paginate(100000);
        return view('EspeIn', compact('especialistas','areas'));
    }


    public function editarespeex($id)
    {
        $proveedor = Proveedor::find($id);

        return view('EditEspeEx', compact('proveedor'));
    }

    public function updateespeex($id, Request $request)
    {
        $proveedor = Proveedor::findOrFail($id);
        $proveedor->fill($request->all());

        $proveedor->save();
        $proveedores = Proveedor::Paginate(100000);
        return view('EspeEx',compact('proveedores'));
    }


    public function agregarespein(Request $request)
    {
        $espe = new User($request->all());
        $areas = Area::paginate(100);

        $espe->save();

        $especialistas = User::Paginate(100000);
        return view('EspeIn', compact('especialistas','areas'));
    }

    public function agregarespeex(Request $request)
    {
        $provee = new Proveedor($request->all());
        $provee->save();

        $proveedores = Proveedor::Paginate(100000);
        return view('EspeEx',compact('proveedores'));
    }

    public function eliminarespein($id)
    {
        $espe = User::find($id);

        $espe->delete();

            $areas = Area::paginate(100);
            $especialistas = User::Paginate(100000);
            return view('EspeIn', compact('especialistas','areas'));
        
    }

    public function eliminarespeex($id)
    {
        $espe = Proveedor::find($id);

        $espe->delete();

        return Redirect::back()->with('message','Operacion Exitosa !');


    }

    public function externos()
    {
        $proveedores = Proveedor::Paginate(100000);
        return view('EspeEx',compact('proveedores'));

    }
}

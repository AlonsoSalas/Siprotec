<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 25/06/15
 * Time: 05:04 AM
 */

namespace siprotec\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use siprotec\Area;
use siprotec\AreaMeta;
use siprotec\Proveedor;
use Input;
use siprotec\Proyecto;
use siprotec\User;
use siprotec\ProyectEspe;
use siprotec\Observacion;
use DateTime;
use siprotec\Upload;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;

class NewMetaController extends Controller {

    public function index(Request $request)
    {
        $areas = Area::all();
        $especialistas = User::all();
        return view('newmeta',compact('areas','especialistas'));
    }

    public function comentario($id_proyecto){
        $proyecto = Proyecto::findOrFail($id_proyecto);
        $comentarios = Observacion::all();
        return view('comentarios',compact('proyecto','comentarios'));
    }

    public function agregarcomentario(Request $request, $id_proyecto){

        $ahora = new DateTime("now");
        $nuevocomentario = new Observacion();
        $nuevocomentario->id_proyecto= $id_proyecto;
        $nuevocomentario->comentario = $request->get('comentario');
        $nuevocomentario->nombre = \Auth::user()->name;
        $nuevocomentario->fecha = $ahora;
        $nuevocomentario->save();

        return Redirect::back()->with('message','Operacion Exitosa !');
    }

    /**
     * @param Request $request
     * @param Redirector $redirect
     * @return \Illuminate\Http\RedirectResponse
     */



    public function store(Request $request, Redirector $redirect)
    {
        $newmeta = new Proyecto($request->all());
        $areas = Area::all();
        $areameta = AreaMeta::all();
        $ahora = new DateTime("now");

        foreach($areas as $a){
            if($a->nombre == $request->get('id_departamento')){
                $newmeta->id_departamento=$a->nombre;
                $sho = $a->short;
            }
        }
        $newmeta->save();

        foreach($request->only('file') as $t) {
            if ($t) {
                $fileName = $this->normaliza($t->getClientOriginalName());
                $path = "storage/".$newmeta->nombre;
                if ($t->isValid()) {
                    $t->move($path, $fileName);
                    chmod($path , 0777);
                    $upload = new Upload();
                    $upload->filename = $fileName;
                    $upload->id_proyecto=$newmeta->id_proyecto;
                    $upload->fecha=$ahora;
                    $upload->tipo='levantamiento';

                    if ($upload->save()) {
                        $newmeta->levantamiento = $fileName;
                    } else {
                        \File::delete($path . "/" . $fileName);
                    }
                }
                break;
            }
        }
        foreach($request->only('file2') as $t) {
            if ($t) {
                $fileName = $this->normaliza($t->getClientOriginalName());
                $path = "storage/".$newmeta->nombre;
                if ($t->isValid()) {
                    $t->move($path, $fileName);
                    chmod($path . "/" . $fileName, 0777);
                    $upload = new Upload();
                    $upload->filename = $fileName;
                    $upload->id_proyecto=$newmeta->id_proyecto;
                    $upload->fecha=$ahora;
                    $upload->tipo='plantrabajo';
                    if ($upload->save()) {
                        $newmeta->plantrabajo=$fileName;
                    } else {
                        \File::delete($path . "/" . $fileName);

                    }
                }
                break;
            }
        }
        foreach($request->only('file3') as $t) {
            if ($t) {
                $mime = $t->getMimeType();
                $fileName = $this->normaliza($t->getClientOriginalName());
                $path = "storage/".$newmeta->nombre;
                if ($t->isValid()) {
                    $t->move($path, $fileName);
                    chmod($path . "/" . $fileName, 0777);
                    $upload = new Upload();
                    $upload->filename = $fileName;
                    $upload->id_proyecto=$newmeta->id_proyecto;
                    $upload->fecha=$ahora;
                    $upload->tipo='certificacion';
                    if ($upload->save()) {
                        $newmeta->certificacion=$fileName;
                    } else {
                        \File::delete($path . "/" . $fileName);

                    }
                }
                break;
            }
        }

        $newmeta->save();
        if($newmeta->tipo == 'Incidencia'){

            $result =0;
            $proyectos = Proyecto::all();
            foreach ($proyectos as $pro) {
                $fe = new DateTime($pro->fecha_ingreso);
                if($pro->tipo == 'Incidencia' && ($fe->format('Y') == $ahora->format('Y'))) {
                    If($pro->codigo)
                        $result = $pro->codigo;
                }
            }
            $result = preg_replace("/[^0-9]/", "", $result);
            $indice=(integer) $result+1;
            $newmeta->codigo = 'INC '.$indice.' - '.$sho;
            $newmeta->save();


        }else{
            $cont = 0;
            $ahora = new DateTime("now");
            foreach($areameta as $t){
                $ano = date_create($t->anio);
                if($newmeta->id_departamento == $t->id_area and $ahora->format('Y') == $ano->format('Y')){
                    $cont = $cont +1;
                }
            }
            if(!$cont){
                foreach($request->only('file1') as $t) {
                    if ($t) {
                        $fileName = $this->normaliza($t->getClientOriginalName());
                        $path = "storage/".$newmeta->nombre;
                                if ($t->isValid()) {
                                    $t->move($path, $fileName);
                                    chmod($path . "/" . $fileName, 0777);
                                    $upload = new Upload();
                                    $upload->filename = $fileName;
                                    $upload->id_proyecto=$newmeta->id_proyecto;
                                    $upload->fecha=$ahora;
                                    $upload->tipo='fouct03';
                                    if ($upload->save()) {
                                        $newmeta->fouct03=$fileName;
                                    } else {
                                        \File::delete($path . "/" . $fileName);

                                    }
                                }
                                break;
                    }
                }
            }else{
                foreach($areameta as $t){
                    $ano = date_create($t->anio);
                    if($newmeta->id_departamento == $t->id_area and $ahora->format('Y') == $ano->format('Y')){
                        $metaprimera = Proyecto::find($t->id_meta);
                        $newmeta->fouct03=$metaprimera->fouct03;
                        break;
                    }
                }
            }

            $cont = $cont+1;

            $newmeta->codigo = 'MET '.$cont.' - '.$sho;

            $areametanew = new AreaMeta();
            $areametanew->id_area = $newmeta->id_departamento;
            $areametanew->id_meta = $newmeta->id_proyecto;
            $areametanew->anio = $ahora;
            $areametanew->save();

        }

        $newmeta->save();

        return $redirect->route('proyectos.index');
//        return Redirect::back()->with('message','Operacion Exitosa !');
    }

    public function asignarespecialista(Request $request, $id_proyecto){
            $asignacion = new ProyectEspe();
            $asignacion->id_proyecto= $id_proyecto;
            $especialistas = User::all();
            $proyecto = Proyecto::findOrFail($id_proyecto);
            $proyecto->especialista=1;
            $proyecto->ext_int_enum='interno';
            $proyecto->save();
            foreach($especialistas as $t) {
                if ($t->nombre == $request->get('especialista')) {
                    $asignacion->id_especialista = $t->id;
                }
            }
            $asignacion->save();
        return Redirect::back()->with('message','Operacion Exitosa !');
    }

    public function asignarespecialistaex(Request $request, $id_proyecto){

        $asignacion = new ProyectEspe();
        $asignacion->id_proyecto= $id_proyecto;
        $proveedores= Proveedor::all();
        $proyecto = Proyecto::findOrFail($id_proyecto);
        $proyecto->especialista=1;
        $proyecto->ext_int_enum='externo';
        $proyecto->save();
        foreach($proveedores as $t) {
            if ($t->nombre == $request->get('proveedores')) {
                $asignacion->id_proveedor = $t->id_proveedor ;
            }
        }
        $asignacion->save();
        return Redirect::back()->with('message','Operacion Exitosa !');
    }

    public function agregarproveedor(Request $request){
        $proveedor = new Proveedor($request->all());
        $proveedor->save();
        return Redirect::back()->with('message','Operacion Exitosa !');
    }

    public function show($id_proyecto){
        //
    }

    public function editar($id_proyecto){
        $proyecto = Proyecto::findOrFail($id_proyecto);

        $areas = Area::all();
        $cont=0;
        foreach($areas as $a){
            if($a->nombre == $proyecto->id_departamento){
                $cont=$a->nombre;
            }
        }

        $areas = Area::all();
        $especialistas = User::all();
        $proveedores = Proveedor::all();
        $proyectoespe = ProyectEspe::where('id_proyecto', '=', $id_proyecto)->get();
        return view('editarproyecto',compact('proyecto','areas','especialistas','proyectoespe','proveedores','cont'));

    }

    public function eliminarespe($espe){
        $ProyectEspe = ProyectEspe::where('id_especialista', '=', $espe)->firstOrFail();

        $proyecto = Proyecto::findOrFail($ProyectEspe->id_proyecto);
        $ProyectEspe->delete();
        $proyectosespe = ProyectEspe::all();
        $cont =0;
        if($proyectosespe){
            foreach($proyectosespe as $espe) {
                if ($espe->id_proyecto == $proyecto->id_proyecto) {
                    $cont = $cont + 1;
                }
            }
            if($cont==0){
                $proyecto->ext_int_enum = NULL;
                $proyecto->especialista = 0;
            }
            $proyecto->save();
        }

        return Redirect::back()->with('message','Operacion Exitosa !');
    }
    
    public function eliminarprove($id_proyecto){
        $proyecto = Proyecto::findOrFail($id_proyecto);
        $ProyectEspe = ProyectEspe::all();

        foreach($ProyectEspe as $proyectespe){
            if($proyectespe->id_proyecto == $proyecto->id_proyecto){
                $proyectespe->delete();
                $proyecto->ext_int_enum = NULL;
            }
            $proyecto->save();
        }

        return Redirect::back()->with('message','Operacion Exitosa !');
    }

    // FUnciones para Descargar, EStan por separadas
    // se podria simplificar pasando dos valores por parametros
    // pero cuando se pasan dos valores de parametros da error de seguridad con el servidor
    public function descargarlev($id_proyecto){
        $proyecto = Proyecto::findOrFail($id_proyecto);
        $path = "storage/".$proyecto->nombre;
        return \Response::download(
            $path . "/" .$proyecto->levantamiento, $proyecto->levantamiento
        );
    }
    public function eliminarlev($id_proyecto){
        $proyecto = Proyecto::findOrFail($id_proyecto);
        $path = "storage/".$proyecto->nombre;
        File::delete($path . "/" .$proyecto->levantamiento);
        $proyecto->levantamiento=NULL;
        $proyecto->save();
        $archivos = Upload::all();
        foreach($archivos as $file){
            if($file->id_proyecto == $proyecto->id_proyecto and $file->tipo == 'levantamiento'){
                $file->delete();
            }
        }


        return Redirect::back()->with('message','Operacion Exitosa !');
    }
    public function descargarfo($id_proyecto){
        $proyecto = Proyecto::findOrFail($id_proyecto);
        $areameta = AreaMeta::all();
        $ahora = new DateTime("now");

        foreach($areameta as $t){
            $ano = date_create($t->anio);
            if($proyecto->id_departamento == $t->id_area and $ahora->format('Y') == $ano->format('Y')){
                $metaprimera = Proyecto::find($t->id_meta);
                $path = "storage/".$metaprimera->nombre;
                return \Response::download(
                    $path . "/" .$proyecto->fouct03, $proyecto->fouct03
                );
            }
        }


    }
    public function eliminarfo($id_proyecto){
        $proyecto = Proyecto::findOrFail($id_proyecto);
        $path = "storage/".$proyecto->nombre;
        File::delete($path . "/" .$proyecto->fouct03);
        $proyecto->fouct03=NULL;
        $proyecto->save();
        $archivos = Upload::all();
        foreach($archivos as $file){
            if($file->id_proyecto == $proyecto->id_proyecto and $file->tipo == 'fouct03'){
                $file->delete();
            }
        }
        return Redirect::back()->with('message','Operacion Exitosa !');
    }
    public function descargarplan($id_proyecto){
        $proyecto = Proyecto::findOrFail($id_proyecto);
        $path = "storage/".$proyecto->nombre;
        return \Response::download(
            $path . "/" .$proyecto->plantrabajo, $proyecto->plantrabajo
        );
    }
    public function eliminarplan($id_proyecto){
        $proyecto = Proyecto::findOrFail($id_proyecto);
        $path = "storage/".$proyecto->nombre;
        File::delete($path . "/" .$proyecto->plantrabajo);
        $proyecto->plantrabajo=NULL;
        $proyecto->save();
        $archivos = Upload::all();
        foreach($archivos as $file){
            if($file->id_proyecto == $proyecto->id_proyecto and $file->tipo == 'plantrabajo'){
                $file->delete();
            }
        }
        return Redirect::back()->with('message','Operacion Exitosa !');
    }
    public function descargarcer($id_proyecto){
        $proyecto = Proyecto::findOrFail($id_proyecto);
        $path = "storage/".$proyecto->nombre;
        return \Response::download(
            $path . "/" .$proyecto->certificacion, $proyecto->certificacion
        );
    }
    public function eliminarcer($id_proyecto){
        $proyecto = Proyecto::findOrFail($id_proyecto);
        $path = "storage/".$proyecto->nombre;
        File::delete($path . "/" .$proyecto->certificacion);
        $proyecto->certificacion=NULL;
        $proyecto->save();
        $archivos = Upload::all();
        foreach($archivos as $file){
            if($file->id_proyecto == $proyecto->id_proyecto and $file->tipo == 'certificacion'){
                $file->delete();
            }
        }
        return Redirect::back()->with('message','Operacion Exitosa !');
    }
    public function descargarorden($id_proyecto){
        $proyecto = Proyecto::findOrFail($id_proyecto);
        $path = "storage/".$proyecto->nombre;
        return \Response::download(
            $path . "/" .$proyecto->ordencompra, $proyecto->ordencompra
        );
    }
    public function eliminarorden($id_proyecto){
        $proyecto = Proyecto::findOrFail($id_proyecto);
        $path = "storage/".$proyecto->nombre;
        File::delete($path . "/" .$proyecto->ordencompra);
        $proyecto->ordencompra=NULL;
        $proyecto->save();

        return Redirect::back()->with('message','Operacion Exitosa !');
    }
    public function descargarfactura($id_proyecto){
        $proyecto = Proyecto::findOrFail($id_proyecto);
        $path = "storage/".$proyecto->nombre;
        return \Response::download(
            $path . "/" .$proyecto->levantamiento, $proyecto->factura
        );
    }
    public function eliminarfactura($id_proyecto){
        $proyecto = Proyecto::findOrFail($id_proyecto);
        $path = "storage/".$proyecto->nombre;
        File::delete($path . "/" .$proyecto->factura);
        $proyecto->factura=NULL;
        $proyecto->save();
        return Redirect::back()->with('message','Operacion Exitosa !');
    }
    public function descargarindi($id_proyecto){
        $proyecto = Proyecto::findOrFail($id_proyecto);
        $path = "storage/".$proyecto->nombre;
        return \Response::download(
            $path . "/" .$proyecto->indicadores, $proyecto->indicadores
        );
    }
    public function eliminarindi($id_proyecto){
        $proyecto = Proyecto::findOrFail($id_proyecto);
        $path = "storage/".$proyecto->nombre;
        File::delete($path . "/" .$proyecto->indicadores);
        $proyecto->indicadores=NULL;
        $proyecto->save();
        return Redirect::back()->with('message','Operacion Exitosa !');
    }
    public function descargarinforme($id_proyecto){
        $proyecto = Proyecto::findOrFail($id_proyecto);
        $path = "storage/".$proyecto->nombre;
        return \Response::download(
            $path . "/" .$proyecto->informe, $proyecto->informe
        );
    }
    public function eliminarinforme($id_proyecto){
        $proyecto = Proyecto::findOrFail($id_proyecto);
        $path = "storage/".$proyecto->nombre;
        File::delete($path . "/" .$proyecto->informe);
        $proyecto->informe=NULL;
        $proyecto->save();
        return Redirect::back()->with('message','Operacion Exitosa !');
    }

    function normaliza ($cadena){
        $originales = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
        $modificadas = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
        $cadena = utf8_decode($cadena);
        $cadena = strtr($cadena, utf8_decode($originales), $modificadas);
        $cadena = strtolower($cadena);
        return utf8_encode($cadena);
    }

    public function update($id_proyecto, Request $request){
        $proyecto = Proyecto::findOrFail($id_proyecto);
        $proyecto->fill($request->all());
        $areameta = AreaMeta::all();
        $areas = Area::all();

        $ahora = new DateTime("now");
        foreach($areas as $a){
	    if($request->get('id_departamento')){
              if($a->nombre == $request->get('id_departamento')){
                  $proyecto->id_departamento=$a->nombre;
                  $sho = $a->short;
              }
            }
        }


        foreach($request->only('file') as $t) {
            if ($t) {

                $fileName = $this->normaliza($t->getClientOriginalName());
                $path = "storage/".$proyecto->nombre;
                     if ($t->isValid()) {
                         $t->move($path, $fileName);
                         chmod($path . "/" . $fileName, 0777);
                         $upload = new Upload();
                         $upload->filename = $fileName;
                         $upload->id_proyecto=$proyecto->id_proyecto;
                         $upload->fecha=$ahora;
                         $upload->tipo='levantamiento';

                         if ($upload->save()) {
                             $proyecto->levantamiento = $fileName;
                         } else {
                             \File::delete($path . "/" . $fileName);
                         }
                     }
                        break;
            }
        }
        foreach($request->only('file1') as $t) {
            if ($t) {
                $fileName = $this->normaliza($t->getClientOriginalName());
                $path = "storage/".$proyecto->nombre;
                        if ($t->isValid()) {
                            $t->move($path, $fileName);
                            chmod($path . "/" . $fileName, 0777);
                            $upload = new Upload();
                            $upload->filename = $fileName;
                            $upload->id_proyecto=$proyecto->id_proyecto;
                            $upload->fecha=$ahora;
                            $upload->tipo='fouct03';
                            if ($upload->save()) {
                                $proyecto->fouct03=$fileName;
                            } else {
                                \File::delete($path . "/" . $fileName);

                            }
                        }
                        break;
            }
        }
        foreach($request->only('file2') as $t) {
            if ($t) {
                $fileName = $this->normaliza($t->getClientOriginalName());
                $path = "storage/".$proyecto->nombre;
                        if ($t->isValid()) {
                            $t->move($path, $fileName);
                            chmod($path . "/" . $fileName, 0777);
                            $upload = new Upload();
                            $upload->filename = $fileName;
                            $upload->id_proyecto=$proyecto->id_proyecto;
                            $upload->fecha=$ahora;
                            $upload->tipo='plantrabajo';
                            if ($upload->save()) {
                                $proyecto->plantrabajo=$fileName;
                            } else {
                                \File::delete($path . "/" . $fileName);

                            }
                        }
                        break;
            }
        }
        foreach($request->only('file3') as $t) {
            if ($t) {
                //dd($t);
                $fileName = $this->normaliza($t->getClientOriginalName());
                $path = "storage/".$proyecto->nombre;
                        if ($t->isValid()) {
                            $t->move($path, $fileName);
                            chmod($path . "/" . $fileName, 0777);
                            $upload = new Upload();
                            $upload->filename = $fileName;
                            $upload->id_proyecto=$proyecto->id_proyecto;
                            $upload->fecha=$ahora;
                            $upload->tipo='certificacion';
                            if ($upload->save()) {
                                $proyecto->certificacion=$fileName;
                            } else {
                                \File::delete($path . "/" . $fileName);

                            }
                        }
                        break;
            }
        }
        foreach($request->only('file4') as $t) {
            if ($t) {
                $fileName = $this->normaliza($t->getClientOriginalName());
                $path = "storage/".$proyecto->nombre;
                if ($t->isValid()) {
                    $t->move($path, $fileName);
                    chmod($path . "/" . $fileName, 0777);
                    $upload = new Upload();
                    $upload->filename = $fileName;
                    $upload->id_proyecto=$proyecto->id_proyecto;
                    $upload->fecha=$ahora;
                    if ($upload->save()) {
                        $proyecto->ordencompra=$fileName;
                    } else {
                        \File::delete($path . "/" . $fileName);

                    }
                }
                break;
            }
        }
        foreach($request->only('file5') as $t) {
            if ($t) {
                $fileName = $this->normaliza($t->getClientOriginalName());
                $path = "storage/".$proyecto->nombre;
                if ($t->isValid()) {
                    $t->move($path, $fileName);
                    chmod($path . "/" . $fileName, 0777);
                    $upload = new Upload();
                    $upload->filename = $fileName;
                    $upload->id_proyecto=$proyecto->id_proyecto;
                    $upload->fecha=$ahora;
                    if ($upload->save()) {
                        $proyecto->factura=$fileName;
                    } else {
                        \File::delete($path . "/" . $fileName);

                    }
                }
                break;
            }
        }

        foreach($request->only('file6') as $t) {
            if ($t) {
                $fileName = $this->normaliza($t->getClientOriginalName());
                $path = "storage/".$proyecto->nombre;
                if ($t->isValid()) {
                    $t->move($path, $fileName);
                    chmod($path . "/" . $fileName, 0777);
                    $upload = new Upload();
                    $upload->filename = $fileName;
                    $upload->id_proyecto=$proyecto->id_proyecto;
                    $upload->fecha=$ahora;
                    if ($upload->save()) {
                        $proyecto->indicadores=$fileName;
                    } else {
                        \File::delete($path . "/" . $fileName);

                    }
                }
                break;
            }
        }
        foreach($request->only('file7') as $t) {
            if ($t) {
                $fileName = $this->normaliza($t->getClientOriginalName());
                $path = "storage/".$proyecto->nombre;
                if ($t->isValid()) {
                    $t->move($path, $fileName);
                    chmod($path . "/" . $fileName, 0777);
                    $upload = new Upload();
                    $upload->filename = $fileName;
                    $upload->id_proyecto=$proyecto->id_proyecto;
                    $upload->fecha=$ahora;
                    if ($upload->save()) {
                        $proyecto->informe=$fileName;
                    } else {
                        \File::delete($path . "/" . $fileName);

                    }
                }
                break;
            }
        }
        $proyecto->save();

        if($proyecto->tipo == 'Incidencia'){
          if(isset($sho)){
                $result = preg_replace("/[^0-9]/", "", $proyecto->codigo);
                $proyecto->codigo = 'INC '.$result.' - '.$sho;
          }
        }else{

        }
        $proyecto->save();

        return Redirect::back()->with('message','Operacion Exitosa !');
    }

    public function save(Request $request){
        if(!\Input::file("file"))
        {
            return redirect('uploads')->with('error-message', 'File has required field');
        }

        $mime = \Input::file('file')->getMimeType();
        $extension = strtolower(\Input::file('file')->getClientOriginalExtension());
        $fileName = \Input::file('file')->getClientOriginalName().'.'.$extension;
        $path = "storage";
                if (\Request::file('file')->isValid())
                {
                    \Request::file('file')->move($path, $fileName);
                    chmod($path."/".$fileName, 0777);
                    $upload = new Upload();
                    $upload->filename = $fileName;
                    if($upload->save())
                    {
                        return redirect('uploads')->with('success-message', 'File has been uploaded');
                    }
                    else
                    {
                        \File::delete($path."/".$fileName);
                        return redirect('uploads')->with('error-message', 'An error ocurred saving data into database');
                    }
                }

    }

    public function eliminarproyect($id)
    {
        $proyecto = Proyecto::find($id);

        if (is_null ($proyecto))
        {
            App::abort(404);
        }

        $path = "storage/".$proyecto->nombre;
        File::delete($path);

        $proyecto->delete();


        return Redirect::back()->with('message','Operacion Exitosa !');

    }
}

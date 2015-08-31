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
use siprotec\ProyectEspe;
use siprotec\Proyecto;
use siprotec\User;
use DateTime;
use siprotec\Upload;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;

class NewMetaController extends Controller {

    public function index()
    {
        $areas = Area::paginate(25)->lists('nombre');
        $especialistas = User::paginate(25);
        return view('newmeta',compact('areas','especialistas'));
    }

    /**
     * @param Request $request
     * @param Redirector $redirect
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Redirector $redirect)
    {
        $newmeta = new Proyecto($request->all());
        $areas = Area::paginate(100);
        $areameta = AreaMeta::paginate(1000);
        $ahora = new DateTime("now");

        foreach($areas as $a){
            if($a->id_area == $request->get('id_departamento')){
                $newmeta->id_departamento=$a->nombre;
                $sho = $a->short;
            }
        }
        $newmeta->save();
        ini_set('post_max_size','8M');
        ini_set('upload_max_filesize','8M');
        ini_set('max_execution_time','1000');
        ini_set('max_input_time','1000');

        foreach($request->only('file') as $t) {
            if ($t) {
                $mime = $t->getMimeType();
                $extension = strtolower($t->getClientOriginalExtension());
                $fileName = $t->getClientOriginalName() . '.' . $extension;
                $path = "storage/".$newmeta->nombre;

                switch ($mime) {
                    case "image/jpeg":
                    case "image/png":
                    case "image/gif":
                    case "application/pdf":
                        if ($t->isValid()) {
                            $t->move($path, $fileName);
                            chmod($path . "/" . $fileName, 0777);
                            $upload = new Upload();
                            $upload->filename = $fileName;
                            $upload->id_proyecto=$newmeta->id_proyecto;
                            $upload->fecha=$ahora;
                            $upload->tipo='levantamiento';
                            if ($upload->save()) {
                                $newmeta->levantamiento=$fileName;
                            } else {
                                \File::delete($path . "/" . $fileName);

                            }
                        }
                        break;

                }
            }
        }
        foreach($request->only('file2') as $t) {
            if ($t) {
                $mime = $t->getMimeType();
                $extension = strtolower($t->getClientOriginalExtension());
                $fileName = $t->getClientOriginalName() . '.' . $extension;
                $path = "storage/".$newmeta->nombre;

                switch ($mime) {
                    case "image/jpeg":
                    case "image/png":
                    case "image/gif":
                    case "application/pdf":
                        if ($t->isValid()) {
                            $t->move($path, $fileName);
                            chmod($path . "/" . $fileName, 0777);
                            $upload = new Upload();
                            $upload->filename = $fileName;
                            $upload->id_proyecto=$newmeta->id_proyecto;
                            $upload->fecha=$ahora;
                            $upload->tipo='plantrabajo';
                            if ($upload->save()) {
                                $newmeta->plantrabajo=$path . "/" . $fileName;
                            } else {
                                \File::delete($path . "/" . $fileName);

                            }
                        }
                        break;

                }
            }
        }
        foreach($request->only('file3') as $t) {
            if ($t) {
                $mime = $t->getMimeType();
                $extension = strtolower($t->getClientOriginalExtension());
                $fileName = $t->getClientOriginalName() . '.' . $extension;
                $path = "storage/".$newmeta->nombre;

                switch ($mime) {
                    case "image/jpeg":
                    case "image/png":
                    case "image/gif":
                    case "application/pdf":
                        if ($t->isValid()) {
                            $t->move($path, $fileName);
                            chmod($path . "/" . $fileName, 0777);
                            $upload = new Upload();
                            $upload->filename = $fileName;
                            $upload->id_proyecto=$newmeta->id_proyecto;
                            $upload->fecha=$ahora;
                            $upload->tipo='certificacion';
                            if ($upload->save()) {
                                $newmeta->certificacion=$path . "/" . $fileName;
                            } else {
                                \File::delete($path . "/" . $fileName);

                            }
                        }
                        break;

                }
            }
        }
        $newmeta->save();

        if($newmeta->tipo == 'Incidencia'){
            $newmeta->codigo = 'INC '.$newmeta->id_proyecto.' - '.$sho;
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
                        $mime = $t->getMimeType();
                        $extension = strtolower($t->getClientOriginalExtension());
                        $fileName = $t->getClientOriginalName() . '.' . $extension;
                        $path = "storage/".$newmeta->nombre;

                        switch ($mime) {
                            case "image/jpeg":
                            case "image/png":
                            case "image/gif":
                            case "application/pdf":
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
            $especialistas = User::paginate(25);
            $proyecto = Proyecto::findOrFail($id_proyecto);
            $proyecto->especialista=1;
            $proyecto->ext_int_enum='interno';
            $proyecto->save();

            foreach($especialistas as $t) {
                if ($t->id == $request->get('especialista')) {
                    $asignacion->id_especialista = $t->id;
                }
            }
            $asignacion->save();
        return Redirect::back()->with('message','Operacion Exitosa !');
    }

    public function asignarespecialistaex(Request $request, $id_proyecto){

        $asignacion = new ProyectEspe();
        $asignacion->id_proyecto= $id_proyecto;
        $proveedores= Proveedor::paginate(1000);
        $proyecto = Proyecto::findOrFail($id_proyecto);
        $proyecto->especialista=1;
        $proyecto->ext_int_enum='externo';
        $proyecto->save();
        foreach($proveedores as $t) {
            if ($t->id_proveedor == $request->get('proveedores')) {
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

        $areas = Area::paginate(25)->lists('nombre');
        $especialistas = User::paginate(25);
        $proveedores = Proveedor::paginate(1000);
        $proyectoespe = ProyectEspe::where('id_proyecto', '=', $id_proyecto)->get();
        return view('editarproyecto',compact('proyecto','areas','especialistas','proyectoespe','proveedores'));

    }

    public function eliminarespe($id_proyecto){

        $proyecto = Proyecto::findOrFail($id_proyecto);
        $ProyectEspe = ProyectEspe::paginate(100);

        foreach($ProyectEspe as $proyectespe){
            if($proyectespe->id_proyecto == $proyecto->id_proyecto){
                $proyectespe->delete();
                $proyecto->ext_int_enum = NULL;
            }
            $proyecto->save();
        }
        return Redirect::back()->with('message','Operacion Exitosa !');
    }
    
    public function eliminarprove($id_proyecto){
        $proyecto = Proyecto::findOrFail($id_proyecto);
        $ProyectEspe = ProyectEspe::paginate(100);

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
        $extension = mime_content_type($path . "/" .$proyecto->levantamiento);
        $file = File::get($path . "/" .$proyecto->levantamiento);
        return (new Response($file, 200))->header('Content-Type', $extension);
    }
    public function eliminarlev($id_proyecto){
        $proyecto = Proyecto::findOrFail($id_proyecto);
        $path = "storage/".$proyecto->nombre;
        File::delete($path . "/" .$proyecto->levantamiento);
        $proyecto->levantamiento=NULL;
        $proyecto->save();
        $archivos = Upload::paginate(1000);
        foreach($archivos as $file){
            if($file->id_proyecto == $proyecto->id_proyecto and $file->tipo == 'levantamiento'){
                $file->delete();
            }
        }


        return Redirect::back()->with('message','Operacion Exitosa !');
    }
    public function descargarfo($id_proyecto){
        $proyecto = Proyecto::findOrFail($id_proyecto);
        $areameta = AreaMeta::paginate(1000);
        $ahora = new DateTime("now");

        foreach($areameta as $t){
            $ano = date_create($t->anio);
            if($proyecto->id_departamento == $t->id_area and $ahora->format('Y') == $ano->format('Y')){
                $metaprimera = Proyecto::find($t->id_meta);
                $path = "storage/".$metaprimera->nombre;
                $extension = mime_content_type($path . "/" .$metaprimera->fouct03);
                $file = File::get($path . "/" .$metaprimera->fouct03);
                return (new Response($file, 200))->header('Content-Type', $extension);
            }
        }


    }
    public function eliminarfo($id_proyecto){
        $proyecto = Proyecto::findOrFail($id_proyecto);
        $path = "storage/".$proyecto->nombre;
        File::delete($path . "/" .$proyecto->fouct03);
        $proyecto->fouct03=NULL;
        $proyecto->save();
        $archivos = Upload::paginate(1000);
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
        $extension = mime_content_type($path . "/" .$proyecto->plantrabajo);
        $file = File::get($path . "/" .$proyecto->plantrabajo);
        return (new Response($file, 200))->header('Content-Type', $extension);
    }
    public function eliminarplan($id_proyecto){
        $proyecto = Proyecto::findOrFail($id_proyecto);
        $path = "storage/".$proyecto->nombre;
        File::delete($path . "/" .$proyecto->plantrabajo);
        $proyecto->plantrabajo=NULL;
        $proyecto->save();
        $archivos = Upload::paginate(1000);
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
        $extension = mime_content_type($path . "/" .$proyecto->certificacion);
        $file = File::get($path . "/" .$proyecto->certificacion);
        return (new Response($file, 200))->header('Content-Type', $extension);
    }
    public function eliminarcer($id_proyecto){
        $proyecto = Proyecto::findOrFail($id_proyecto);
        $path = "storage/".$proyecto->nombre;
        File::delete($path . "/" .$proyecto->certificacion);
        $proyecto->certificacion=NULL;
        $proyecto->save();
        $archivos = Upload::paginate(1000);
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
        $extension = mime_content_type($path . "/" .$proyecto->ordencompra);
        $file = File::get($path . "/" .$proyecto->ordencompra);
        return (new Response($file, 200))->header('Content-Type', $extension);
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
        $extension = mime_content_type($path . "/" .$proyecto->factura);
        $file = File::get($path . "/" .$proyecto->factura);
        return (new Response($file, 200))->header('Content-Type', $extension);
    }
    public function eliminarfactura($id_proyecto){
        $proyecto = Proyecto::findOrFail($id_proyecto);
        $path = "storage/".$proyecto->nombre;
        File::delete($path . "/" .$proyecto->factura);
        $proyecto->factura=NULL;
        $proyecto->save();
        return Redirect::back()->with('message','Operacion Exitosa !');
    }

    public function update($id_proyecto, Request $request){
        $proyecto = Proyecto::findOrFail($id_proyecto);

        $proyecto->fill($request->all());
        $areameta = AreaMeta::paginate(1000);
        $areas = Area::paginate(100);

        $ahora = new DateTime("now");

        foreach($areas as $a){
            if($a->id_area == $request->get('id_departamento')){
                $proyecto->id_departamento=$a->nombre;
                $sho = $a->short;
            }
            if($proyecto->id_departamento == $a->nombre){
                $sho = $a->short;
            }
        }


        foreach($request->only('file') as $t) {
            if ($t) {
                $fileName = $t->getClientOriginalName() ;
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
                $fileName = $t->getClientOriginalName();
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
                $fileName = $t->getClientOriginalName();
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
                $mime = $t->getMimeType();
                $fileName = $t->getClientOriginalName();
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
                $mime = $t->getMimeType();
                $fileName = $t->getClientOriginalName();
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
                $mime = $t->getMimeType();
                $fileName = $t->getClientOriginalName();
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
        $proyecto->save();

        if($proyecto->tipo == 'Incidencia'){
            $proyecto->codigo = 'INC '.$proyecto->id_proyecto.' - '.$sho;
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

        $proyecto->delete();


        return Redirect::back()->with('message','Operacion Exitosa !');

    }
}
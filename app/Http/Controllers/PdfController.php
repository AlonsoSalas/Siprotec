<?php namespace siprotec\Http\Controllers;


use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use siprotec\Http\Requests;
use siprotec\Http\Controllers\Controller;
use DateTime;
use siprotec\Area;
use siprotec\Upload;
use siprotec\User;
use siprotec\ProyectEspe;
use siprotec\Proveedor;
use siprotec\AreaMeta;
use siprotec\Observacion;
use Illuminate\Http\Request;
use siprotec\Proyecto;
use Symfony\Component\HttpFoundation\Response;
use File;

class PdfController extends Controller {

    /**
     * @param $id_proyecto
     */
    public function invoice(Request $request)
    {
        $especialistas = User::paginate(100);
        $proyectos = Proyecto::paginate(100);
        $proyectoespe = ProyectEspe::paginate(100);
        $areas = Area::paginate(100);
	$comentarios = Observacion::paginate(110000);
        $ahora = new DateTime("now");
        $comment= '';

//        USANDO FPDF
        $pdf3 = new \fpdi\FPDI();
        $pdf3->AddPage('L');
        $pdf3->setSourceFile('FO-UCT-09.pdf');
        $tplIdx = $pdf3->importPage(1);
        $pdf3->useTemplate($tplIdx, 0, 0);
        $pdf3->SetFont('Arial');
        $pdf3->SetFontSize(7);
        $pdf3->SetXY(245, 24);
        $pdf3->Write(0, $ahora->format('d/m/Y'));
        $pdf3->SetFontSize(9);
        $pdf3->SetTextColor(0,0,0);
        $i =39;
        $contad=1;
        foreach($proyectos as $proyecto){
            if ($proyecto->fecha_inicio and $request->get('fecha_inicio')<= $proyecto->fecha_inicio and $request->get('fecha_fin')>= $proyecto->fecha_inicio) {
                if ($proyecto->fecha_inicio) {
                    if ($i < 170) {
                        $inic = new DateTime($proyecto->fecha_inicio);
                        $fin = new DateTime($proyecto->fecha_fin);
                        $diferencia_dias = $inic->diff($fin);
                        $dias_transcurridos = $inic->diff($ahora);
                        //dd($ddias->format('%R%a dias'));
                        $pdf3->SetXY(7, $i);
                        $pdf3->Write(0, $contad);
                        $contad=$contad+1;
                        $pdf3->SetXY(23, $i);
                        foreach ($areas as $a) {
                            if ($a->nombre == $proyecto->id_departamento) {
                                $pdf3->Write(0, $a->short);
                            }
                        }
                        $pdf3->SetXY(45, $i);

                        foreach ($proyectoespe as $t) {
                            if ($t->id_proyecto == $proyecto->id_proyecto) {
                                foreach ($especialistas as $es) {
                                    if ($t->id_especialista == $es->id) {
                                        $pdf3->Write(0, $es->nombre);
                                        $pdf3->SetXY(50, $i + 3);
                                    }
                                }
                            }
                        }
                        $pdf3->SetXY(85, $i);
                        $len = strlen($proyecto->nombre);
                        if ($len > 24) {
                            $len = $len - 24;
                            $pdf3->Write(0, substr($proyecto->nombre, 0, 24));
                            $pdf3->SetXY(85, $i + 3);
                            if ($len > 24) {
                                $len = $len - 24;
                                $pdf3->Write(0, substr($proyecto->nombre, 24, 24));
                                $pdf3->SetXY(85, $i + 6);
                                if ($len > 24) {
                                    $len = $len - 24;
                                    $pdf3->Write(0, substr($proyecto->nombre, 48, 24));
                                    $pdf3->SetXY(85, $i + 9);
                                    if ($len > 24) {
                                        $pdf3->Write(0, substr($proyecto->nombre, 72, 24) . "...");
                                    } else {
                                        $pdf3->Write(0, substr($proyecto->nombre, 72, 24));
                                    }
                                } else {
                                    $pdf3->Write(0, substr($proyecto->nombre, 48, 24));
                                }
                            } else {
                                $pdf3->Write(0, substr($proyecto->nombre, 24, 24));
                            }
                        } else {
                            $pdf3->Write(0, $proyecto->nombre);
                        }
                        $pdf3->SetFontSize(8);
                        $pdf3->SetXY(140, $i);
                        $pdf3->Write(0, $proyecto->fecha_inicio);
                        $pdf3->SetXY(158.5, $i);
                        $pdf3->Write(0, $proyecto->fecha_fin);
                        $pdf3->SetFontSize(9);

                        $pdf3->SetXY(177, $i);
                        if ($ahora >= $fin) {
                            $pdf3->Write(0, "Vencido");
                        } else {
                            if ($dias_transcurridos->format('%R%a dias') >= 0.75 * $diferencia_dias->format('%R%a dias') and $ahora < $fin) {
                                $pdf3->Write(0, "Por Vencer");
                            } else {
                                if ($ahora >= $inic) {
                                    $pdf3->Write(0, "Activo");
                                }
                            }
                        }
                        $pdf3->SetTextColor(0, 0, 0);

                        $pdf3->SetXY(199, $i);
                        if ($ahora >= $fin) {
                            $pdf3->Write(0, "0%");
                        } else {
                            $pdf3->Write(0, round($dias_transcurridos->format('%R%a dias') * 100 / $diferencia_dias->format('%R%a dias')) . '%');
                        }

                        foreach ($comentarios as $com) {
                            if ($com->id_proyecto == $proyecto->id_proyecto) {
                                $comment = $com->comentario;
                            }
                        }
                        $pdf3->SetXY(212, $i);
                        $len = strlen($comment);
                        if ($len > 24) {
                            $len = $len - 24;
                            $pdf3->Write(0, substr($comment, 0, 24));
                            $pdf3->SetXY(212, $i + 3);
                            if ($len > 24) {
                                $len = $len - 24;
                                $pdf3->Write(0, substr($comment, 24, 24));
                                $pdf3->SetXY(212, $i + 6);
                                if ($len > 24) {
                                    $len = $len - 24;
                                    $pdf3->Write(0, substr($comment, 48, 24));
                                    $pdf3->SetXY(212, $i + 9);
                                    if ($len > 24) {
                                        $pdf3->Write(0, substr($comment, 72, 24) . "...");
                                    } else {
                                        $pdf3->Write(0, substr($comment, 72, 24));
                                    }
                                } else {
                                    $pdf3->Write(0, substr($comment, 48, 24));
                                }
                            } else {
                                $pdf3->Write(0, substr($comment, 24, 24));
                            }
                        } else {
                            $pdf3->Write(0,$comment);
                        }
			
                        $i = $i + 15.5;

                    }
                }
            }
        }

	
        $pdf3->Output('newpdf.pdf','I');
    }

    public function reginci(Request $request)
    {
        $proyectos = Proyecto::paginate(100);
        $areas = Area::paginate(25);
        $especialistas = User::paginate(100);
        $proyectoespe = ProyectEspe::paginate(100);
        $ahora = new DateTime("now");

//        USANDO FPDF
        $pdf3 = new \fpdi\FPDI();
        $pdf3->AddPage('L');
        $pdf3->setSourceFile('FO-UCT-05.pdf');
        $tplIdx = $pdf3->importPage(1);
        $pdf3->useTemplate($tplIdx, 0, 0);
        $pdf3->SetFont('Arial');
        $pdf3->SetFontSize(9);
        $pdf3->SetXY(238, 24);
        $pdf3->Write(0, $ahora->format('d/m/Y'));
        $pdf3->SetTextColor(0,0,0);
        $i =47;
        $contad=1;
        foreach($proyectos as $proyect){
            if ($proyect->fecha_inicio and $request->get('fecha_inicio')<= $proyect->fecha_inicio and $request->get('fecha_fin')>= $proyect->fecha_inicio) {
                if ($i < 196) {
                    $pdf3->SetXY(10, $i);
                    $pdf3->Write(0, $contad);
                    $contad=$contad+1;
                    $pdf3->SetXY(21, $i);
                    foreach ($areas as $a) {
                        if ($a->nombre == $proyect->id_departamento) {
                            $pdf3->Write(0, $a->short);
                        }
                    }
                    $pdf3->SetXY(33, $i - 1);
                    $pdf3->SetFontSize(7);
                    foreach ($areas as $a) {
                        if ($a->nombre == $proyect->id_departamento) {
                            $len = strlen($a->nombre);
                            if ($len > 17) {
                                $len = $len - 17;
                                $pdf3->Write(0, substr($a->nombre, 0, 17));
                                $pdf3->SetXY(33, $i + 2);
                                if ($len > 19) {
                                    $pdf3->Write(0, substr($a->nombre, 17, 17) . "...");
                                } else {
                                    $pdf3->Write(0, substr($a->nombre, 17, 17));
                                }
                            } else {
                                $pdf3->Write(0, $a->nombre);
                            }
                        }
                    }
                    $pdf3->SetXY(58, $i - 1);
                    $pdf3->SetFontSize(7);
                    $len = strlen($proyect->nombre);
                    if ($len > 23) {
                        $len = $len - 23;
                        $pdf3->Write(0, substr($proyect->nombre, 0, 23));
                        $pdf3->SetXY(58, $i + 2);
                        if ($len > 29) {
                            $pdf3->Write(0, substr($proyect->nombre, 23, 23) . "...");
                        } else {
                            $pdf3->Write(0, substr($proyect->nombre, 23, 23));
                        }
                    } else {
                        $pdf3->Write(0, $proyect->nombre);
                    }
                    $pdf3->SetXY(97, $i);
                    $pdf3->SetFontSize(7);
                    foreach ($proyectoespe as $t) {
                        if ($t->id_proyecto == $proyect->id_proyecto) {
                            foreach ($especialistas as $es) {
                                if ($t->id_especialista == $es->id) {
                                    foreach ($areas as $a) {
                                        if ($a->nombre == $es->id_area) {

                                            $pdf3->Write(0, $a->responsable);
                                        }
                                    }
                                }
                            }
                        }
                    }

                    $pdf3->SetXY(125, $i - 1);
                    $pdf3->SetFontSize(7);
                    foreach ($proyectoespe as $t) {
                        if ($t->id_proyecto == $proyect->id_proyecto) {
                            foreach ($especialistas as $es) {
                                if ($t->id_especialista == $es->id) {
                                    $len = strlen($es->id_area);
                                    if ($len > 23) {
                                        $len = $len - 23;
                                        $pdf3->Write(0, substr($es->id_area, 0, 23));
                                        $pdf3->SetXY(125, $i + 1);
                                        if ($len > 20) {
                                            $pdf3->Write(0, substr($es->id_area, 23, 23) . "...");
                                        } else {
                                            $pdf3->Write(0, substr($es->id_area, 23, 23));
                                        }
                                    } else {
                                        $pdf3->Write(0, $es->id_area);
                                    }
                                }
                            }
                        }
                    }

                    $pdf3->SetFontSize(7);
                    $pdf3->SetXY(160, $i);
                    foreach ($proyectoespe as $t) {
                        if ($t->id_proyecto == $proyect->id_proyecto) {
                            foreach ($especialistas as $es) {
                                if ($t->id_especialista == $es->id) {
                                    $pdf3->Write(0, $es->nombre);
                                    $pdf3->SetXY(156, $i + 3);
                                }
                            }
                        }
                    }
                    $pdf3->SetFontSize(8);
                    $pdf3->SetXY(187, $i);
                    $pdf3->Write(0, $proyect->fecha_inicio);
                    $pdf3->SetXY(205, $i);
                    $pdf3->Write(0, $proyect->fecha_fin);
                    $pdf3->SetFontSize(9);
//                $pdf3->SetXY(222, $i);
//                $pdf3->Write(0, "x");
                    $pdf3->SetXY(228, $i);
                    if ($proyect->levantamiento) {
                        $pdf3->Write(0, "x");
                    }
                    $pdf3->SetXY(242, $i);
                    if ($proyect->plantrabajo) {
                        $pdf3->Write(0, "x");
                    }
                    $pdf3->SetXY(256, $i);
                    if ($proyect->certificacion) {
                        $pdf3->Write(0, "x");
                    }
                    $i = $i + 8.3;
                }
            }
        }
        $pdf3->Output('newpdf.pdf','I');
    }
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

    public function seguiprovee(Request $request)
    {

        $ahora = new DateTime("now");
        $especialistas = User::paginate(100);
        $proyectos = Proyecto::paginate(100);
        $proyectoespe = ProyectEspe::paginate(100);
        $areas = Area::paginate(25);
        $areameta = AreaMeta::paginate(1000);
        $uploads = Upload::paginate(1000);
        $proveedores = Proveedor::paginate(1000);

        $pdf3 = new \fpdi\FPDI();
        $pdf3->AddPage('L');
        $pdf3->setSourceFile('FO-UCT-12.pdf');
        $tplIdx = $pdf3->importPage(1);
        $pdf3->useTemplate($tplIdx, 0, 0);
        $pdf3->SetFont('Arial');
        $pdf3->SetFontSize(7);
        $pdf3->SetXY(253, 22.7);
        $pdf3->Write(0, $ahora->format('d/m/Y'));
        $pdf3->SetTextColor(0,0,0);
        $i =37;
        $pdf3->SetFontSize(9);
        $contad=1;
        foreach($proyectos as $proyect) {
            if ($proyect->fecha_inicio and $request->get('fecha_inicio')<= $proyect->fecha_inicio and $request->get('fecha_fin')>= $proyect->fecha_inicio){
                if ($proyect->ext_int_enum == 'externo') {
                    $pdf3->SetXY(3, $i);
                    $pdf3->Write(0, $contad);
                    $contad=$contad+1;
                    $pdf3->SetXY(10, $i);
                    $pdf3->Write(0, $proyect->tipo);
                    $pdf3->SetXY(31, $i);
                    $len = strlen($proyect->nombre);
                    if ($len > 23) {
                        $len = $len - 23;
                        $pdf3->Write(0, substr($proyect->nombre, 0, 23));
                        $pdf3->SetXY(31, $i + 2);
                        if ($len > 29) {
                            $pdf3->Write(0, substr($proyect->nombre, 23, 23) . "...");
                        } else {
                            $pdf3->Write(0, substr($proyect->nombre, 23, 23));
                        }
                    } else {
                        $pdf3->Write(0, $proyect->nombre);
                    }
                    $pdf3->SetXY(76, $i);


                    foreach ($areas as $a) {
                        if ($a->nombre == $proyect->id_departamento) {
                            $pdf3->Write(0, $a->responsable);
                        }
                    }
                    $pdf3->SetXY(124, $i);
                    foreach ($proyectoespe as $t) {
                        if ($t->id_proyecto == $proyect->id_proyecto) {
                            foreach ($proveedores as $proveedor) {
                                if ($proveedor->id_proveedor == $t->id_proveedor) {
                                    $len = strlen($proveedor->nombre);
                                    if ($len > 17) {
                                        $len = $len - 17;
                                        $pdf3->Write(0, substr($proveedor->nombre, 0, 17));
                                        $pdf3->SetXY(124, $i + 2);
                                        if ($len > 17) {
                                            $pdf3->Write(0, substr($proveedor->nombre, 17, 17) . "...");
                                        } else {
                                            $pdf3->Write(0, substr($proveedor->nombre, 17, 17));
                                        }
                                    } else {
                                        $pdf3->Write(0, $proveedor->nombre);
                                    }
                                }
                            }
                        }
                    }
                    $pdf3->SetXY(158, $i);
                    foreach ($proyectoespe as $t) {
                        if ($t->id_proyecto == $proyect->id_proyecto) {
                                foreach ($proveedores as $proveedor) {
                                    if ($proveedor->id_proveedor == $t->id_proveedor) {
                                        $len = strlen($proveedor->nombre);
                                        $pdf3->Write(0, $proveedor->responsable);
                                    }
                                }
                        }
                    }



                    $pdf3->SetXY(189.5, $i);
                    $pdf3->SetFontSize(9);
                    if ($proyect->fecha_inicio) {
                        $inic = new DateTime($proyect->fecha_inicio);
                        $pdf3->Write(0, $inic->format('d/m/y'));
                    }
                    $pdf3->SetXY(204, $i);
                    if ($proyect->fecha_fin) {
                        $fin = new DateTime($proyect->fecha_fin);
                        $pdf3->Write(0, $fin->format('d/m/y'));
                    }
                    $pdf3->SetFontSize(9);
                    $pdf3->SetXY(223, $i);
                    if ($proyect->plantrabajo) {
                        $pdf3->Write(0, "x");
                    }
                    $pdf3->SetXY(238, $i);
                    if ($proyect->informe) {
                        $pdf3->Write(0, "x");
                    }
                    $i = $i + 14.5;
                }
            }
        }
        $pdf3->Output('newpdf.pdf','I');
    }

	public function index()
	{
		//
	}

    public function cumplimetesp()
    {
        $ahora = new DateTime("now");
        $pdf3 = new \fpdi\FPDI();
        $pdf3->AddPage('L');
        $pdf3->setSourceFile('FO-UCT-11.pdf');
        $tplIdx = $pdf3->importPage(1);
        $pdf3->useTemplate($tplIdx, 0, 0);
        $pdf3->SetFont('Arial');
        $pdf3->SetFontSize(9);
        $pdf3->SetXY(236, 43);
        $pdf3->Write(0, $ahora->format('d/m/Y'));
        $pdf3->SetXY(60, 43.5);
        $pdf3->Write(0, "SOPORTE E INFRAESTRUCTURA");
        $pdf3->SetXY(90, 50);
        $pdf3->Write(0, "GILBERTO CORREA");
        $pdf3->SetXY(90, 56.5);
        $pdf3->Write(0, "MANUEL ABREU");
        $pdf3->SetTextColor(0,0,0);
        $i =72;
        $pdf3->SetFontSize(8);
        $contad=1;
        for($i;$i<180;$i=$i+3.975){
            $pdf3->SetXY(18, $i);
            $pdf3->Write(0, "12");
            $pdf3->SetXY(30, $i);
            $pdf3->Write(0, "Alonso Salas");
            $pdf3->SetXY(55, $i);
            $pdf3->SetFontSize(7);
            $pdf3->Write(0, "Soporte e Infraestructura");
            $pdf3->SetFontSize(8);
            $pdf3->SetFontSize(7);
            $pdf3->SetXY(135, $i);
            $pdf3->Write(0, "01/02/2014");
            $pdf3->SetXY(153, $i);
            $pdf3->Write(0, "01/02/2014");
            $pdf3->SetXY(170, $i);
            $pdf3->Write(0, "POR VENCER");
            $pdf3->SetFontSize(8);
            $pdf3->SetXY(194, $i);
            $pdf3->Write(0, "86%");
            $pdf3->SetXY(212, $i);
            $pdf3->Write(0, "x");
            $pdf3->SetXY(229, $i);
            $pdf3->Write(0, "x");
            $pdf3->SetXY(245, $i);
            $pdf3->Write(0, "x");
        }
        $pdf3->Output('newpdf.pdf','I');
    }

    public function seguientre()
    {
        $ahora = new DateTime("now");
        $pdf3 = new \fpdi\FPDI();
        $pdf3->AddPage('L');
        $pdf3->setSourceFile('FO-UCT-10.pdf');
        $tplIdx = $pdf3->importPage(1);
        $pdf3->useTemplate($tplIdx, 0, 0);
        $pdf3->SetFont('Arial');
        $pdf3->SetFontSize(9);
        $pdf3->SetXY(55, 29.5);
        $pdf3->Write(0, "SOPORTE E INFRAESTRUCTURA");
        $pdf3->SetXY(60, 34.5);
        $pdf3->Write(0, "MANUEL ABREU");
        $pdf3->SetTextColor(0,0,0);
        $i =47;
        $pdf3->SetFontSize(8);
        for($i;$i<193;$i=$i+4.74){
            $pdf3->SetXY(7, $i);
            $pdf3->Write(0, "12");
            $pdf3->SetXY(16, $i);
            $pdf3->SetFontSize(7);
            $pdf3->Write(0, "Proyecto Numero 2323 ordenado por la Vicepresidencia ");
            $pdf3->SetFontSize(6);
            $pdf3->SetXY(84.5, $i);
            $pdf3->Write(0, "01/02/2014");
            $pdf3->SetXY(96.7, $i);
            $pdf3->Write(0, "01/02/2014");
            $pdf3->SetXY(108.7, $i);
            $pdf3->SetFontSize(5.5);
            $pdf3->Write(0, "POR VENCER");
            $pdf3->SetFontSize(6);
            $pdf3->SetXY(124, $i);
            $pdf3->Write(0, "01/02/2014");
            $pdf3->SetXY(139, $i);
            $pdf3->Write(0, "01/02/2014");
            $pdf3->SetFontSize(8);
            $pdf3->SetXY(154, $i);
            $pdf3->Write(0, "100%");
            $pdf3->SetXY(170, $i);
            $pdf3->Write(0, "x");
            $pdf3->SetXY(182, $i);
            $pdf3->Write(0, "x");
            $pdf3->SetXY(194, $i);
            $pdf3->Write(0, "x");
            $pdf3->SetXY(203, $i);
            $pdf3->Write(0, "100 Hrs");
            $pdf3->SetXY(217, $i);
            $pdf3->Write(0, "89 Hrs");
        }
        $pdf3->Output('newpdf.pdf','I');
    }


    public function infoavanc()
    {
        $ahora = new DateTime("now");
        $pdf3 = new \fpdi\FPDI();
        $pdf3->AddPage();
        $pdf3->setSourceFile('FO-UCT-08.pdf');
        $tplIdx = $pdf3->importPage(1);
        $pdf3->useTemplate($tplIdx, 0, 0);
        $pdf3->SetFont('Arial');
        $pdf3->SetFontSize(10);
        $pdf3->SetXY(35, 40);
        $pdf3->Write(0, "12");
        $pdf3->SetXY(75, 40);
        $pdf3->Write(0, $ahora->format('Y'));
        $pdf3->SetXY(140, 38);
        $pdf3->SetFontSize(6.5);
        $pdf3->Write(0, $ahora->format('d/m/Y'));
        $pdf3->SetXY(165, 38);
        $pdf3->Write(0, $ahora->format('d/m/Y'));
        $pdf3->SetTextColor(0,0,0);
        $i =70;
        $pdf3->SetFontSize(10);
        for($i;$i<193;$i=$i+15.8){
            $pdf3->SetXY(16, $i);
            $pdf3->SetFontSize(10);
            $pdf3->Write(0, "Proyecto Numero por la Vicepresidencia ");
            $pdf3->SetXY(90, $i);
            $pdf3->Write(0, "01/02/2014");
            $pdf3->SetXY(120, $i);
            $pdf3->Write(0, "01/02/2014");
            $pdf3->SetXY(144, $i);
            $pdf3->Write(0, "POR VENCER");
            $pdf3->SetXY(183, $i);
            $pdf3->Write(0, "NO");
        }
        $pdf3->AddPage();
        $tplIdx = $pdf3->importPage(2);
        $pdf3->useTemplate($tplIdx, 0, 0);
        $pdf3->Output('newpdf.pdf','I');
    }

    public function reportind()
    {
        $ahora = new DateTime("now");
        $pdf3 = new \fpdi\FPDI();
        $pdf3->AddPage();
        $pdf3->setSourceFile('FO-UCT-07.pdf');
        $tplIdx = $pdf3->importPage(1);
        $pdf3->useTemplate($tplIdx, 0, 0);
        $pdf3->Output('newpdf.pdf','I');
    }

    public function matrzmetecs(Request $request)
    {
        $especialistas = User::paginate(100);
        $proyectos = Proyecto::paginate(100);
        $proyectoespe = ProyectEspe::paginate(100);
        $areas = Area::paginate(25);
        $areameta = AreaMeta::paginate(1000);
        $uploads = Upload::paginate(1000);
        $proveedores = Proveedor::paginate(1000);

        $ahora = new DateTime("now");
        $pdf3 = new \fpdi\FPDI();
        $pdf3->AddPage('L');
        $pdf3->setSourceFile('FO-UCT-06.pdf');
        $tplIdx = $pdf3->importPage(1);
        $pdf3->useTemplate($tplIdx, 0, 0);
        $pdf3->SetFont('Arial');
        $pdf3->SetFontSize(9);
        $pdf3->SetTextColor(0,0,0);
        $i =42;
        $pdf3->SetFontSize(8);
        $contad=1;
        foreach($proyectos as $proyect) {
            if ($proyect->fecha_inicio and $request->get('fecha_inicio') <= $proyect->fecha_inicio and $request->get('fecha_fin') >= $proyect->fecha_inicio) {
                if ($i < 190 and $proyect->tipo == 'Meta') {
                    $pdf3->SetXY(13, $i);
                    $pdf3->Write(0, $contad);
                    $contad=$contad+1;
                    $pdf3->SetXY(23, $i);
                    foreach ($areas as $a) {
                        if ($a->nombre == $proyect->id_departamento) {
//                        $pdf3->Write(0, $a->short);
                            $len = strlen($a->nombre);
                            if ($len > 21) {
                                $pdf3->Write(0, substr($a->nombre, 0, 24) . "...");
                            } else {
                                $pdf3->Write(0, $a->nombre);
                            }
                        }
                    }
                    $pdf3->SetXY(65, $i);
                    $cont = 0;
                    foreach ($areameta as $t) {
                        $ano = date_create($t->anio);
                        if ($proyect->id_departamento == $t->id_area and $ahora->format('Y') == $ano->format('Y')) {
                            $cont = $cont + 1;
                        }
                    }
                    $pdf3->Write(0, $cont);
                    $pdf3->SetXY(77, $i);
                    $len = strlen($proyect->nombre);
                    if ($len > 22) {
                        $pdf3->Write(0, substr($proyect->nombre, 0, 22) . "...");
                    } else {
                        $pdf3->Write(0, $proyect->nombre);
                    }
                    $pdf3->SetXY(125, $i);
                    $pdf3->Write(0, $proyect->prioridad);
                    $pdf3->SetXY(143, $i);
                    foreach ($proyectoespe as $t) {
                        if ($t->id_proyecto == $proyect->id_proyecto) {
                            if ($proyect->ext_int_enum == 'interno') {
                                foreach ($especialistas as $es) {
                                    if ($t->id_especialista == $es->id) {
                                        $len = strlen($es->nombre);
                                        $pdf3->Write(0, $es->nombre);
                                    }
                                }
                            } else {
                                foreach ($proveedores as $proveedor) {
                                    if ($proveedor->id_proveedor == $t->id_proveedor) {
                                        $len = strlen($proveedor->nombre);
                                        if ($len > 12) {
                                            $pdf3->Write(0, substr($proveedor->nombre, 0, 12) . "...");
                                        } else {
                                            $pdf3->Write(0, $proveedor->nombre);
                                        }
                                        //$pdf3->Write(0, $proveedor->nombre);
                                    }
                                }
                            }
                        }
                    }
                    $pdf3->SetXY(168, $i);
                    foreach ($areameta as $t) {
                        if ($proyect->id_departamento == $t->id_area and $ahora->format('Y') == $ano->format('Y')) {
                            $fecha = new DateTime($t->anio);
                            $pdf3->Write(0, $fecha->format('d/m/y'));
                            break;
                        }
                    }
                    $pdf3->SetXY(190, $i);
                    foreach ($uploads as $archivo) {
                        if ($archivo->id_proyecto == $proyect->id_proyecto and $archivo->tipo == 'levantamiento') {
                            $fecha = new DateTime($t->anio);
                            $pdf3->Write(0, $fecha->format('d/m/y'));
                        }
                    }
                    $pdf3->SetXY(217, $i);
                    foreach ($uploads as $archivo) {
                        if ($archivo->id_proyecto == $proyect->id_proyecto and $archivo->tipo == 'certificacion') {
                            $fecha = new DateTime($t->anio);
                            $pdf3->Write(0, $fecha->format('d/m/y'));
                        }
                    }
                    $pdf3->SetXY(239, $i);
                    $fin = new DateTime($proyect->fecha_fin);
                    if ($proyect->certificacion) {
                        $pdf3->Write(0, "Certificado");
                    } else {
                        if ($proyect->fecha_inicio and $ahora >= $fin) {
                            $pdf3->Write(0, "Vencido");
                        } else {
                            if ($proyect->especialista) {
                                $pdf3->Write(0, "En Desarrollo");
                            } else {
                                $pdf3->SetFontSize(6);
                                $pdf3->Write(0, "Pendiente por asignar");
                                $pdf3->SetFontSize(8);
                            }
                        }
                    }
                    $i = $i + 4.57;
                }else{

                }
            }
        }
        $pdf3->Output('newpdf.pdf','I');
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}

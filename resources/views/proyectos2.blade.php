@extends('newhomepro')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Proyectos
                <small>Metas e Incidencias</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Metas e Incidencias</a></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Metas Tecnologicas</h3>
                            <div class="box-tools">
                                <div class="input-group" style="width: 150px;">
                                    <a href="{{ url('/newmeta') }}" >
                                        <button class="btn btn-block btn-primary btn-sm">Meta Nueva</button>
                                    </a>
                                </div>
                            </div>
                        </div><!-- /.box-header -->
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover">
                                <tr>
                                    <th>Cod.</th>
                                    <th>Gerencia/Unidad</th>
                                    <th>Status</th>
                                    <th>Proyecto</th>
                                    <th>Prioridad</th>
                                    <th>Responable</th>
                                </tr>
                                @foreach($proyectos as $proyecto)
                                    {{--Escribo en PHP Plano funcion para calcular los dias en los que va el proyecto--}}
                                    <?php
                                    $ahora = new DateTime("now");
                                    $inic = new DateTime($proyecto->fecha_inicio);
                                    $fin = new DateTime($proyecto->fecha_fin);
                                    $diferencia_dias=$inic->diff($fin);
                                    $dias_transcurridos=$inic->diff($ahora)
                                    ?>
                                    @if($proyecto->tipo == "Meta")
                                        <tr>
                                            <td><small>{{$proyecto->codigo}}</small></td>
                                            <td>{{$proyecto->id_departamento}}</td>
                                            @if($proyecto->certificacion)
                                                <td><span class="label label-success">Certificado</span></td>
                                            @else
                                                @if($proyecto->fecha_inicio and $ahora>=$fin)
                                                    <td><span class="label label-danger">Vencido</span></td>
                                                @else
                                                    @if($proyecto->especialista)
                                                        <td><span class="label label-success">En Desarrollo</span></td>
                                                    @else
                                                        <td><span class="label label-warning">Pendiente por asignar</span></td>
                                                    @endif
                                                @endif
                                            @endif
                                            <td>{{$proyecto->nombre}}</td>
                                            <td>{{$proyecto->prioridad}}</td>
                                            <td>
                                                @foreach($ProyectEspe as $t)
                                                    @if($t->id_proyecto == $proyecto->id_proyecto)
                                                        @if($proyecto->ext_int_enum == 'interno')
                                                            @foreach($especialistas as $es)
                                                                @if($t->id_especialista == $es->id)
                                                                    <i class="fa fa-fw fa-user"></i>{{$es->nombre}}<br>
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            @foreach($proveedores as $es)
                                                                @if($t->id_proveedor == $es->id_proveedor)
                                                                    <i class="fa fa-fw fa-building"></i>{{$es->nombre}}<br>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                <a href="{{ url('editarproyecto', $proyecto) }}"><i class="fa fa-fw fa-edit"></i>Editar</a>
                                                <a href="{{ url('eliminarproyect', $proyecto) }}" onclick="return confirm('Seguro que desea eliminar?')" class="btn-delete"><i class="fa fa-fw fa-times"></i>Eliminar</a>
                                                <a href="{{ url('comentario', $proyecto) }}"><i class="fa fa-fw fa-comment"></i>Comentar</a>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </table>
                            {!! $proyectos->render() !!}
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Incidencias</h3>
                            <div class="box-tools">
                                <div class="input-group" style="width: 150px;">
                                    <a href="{{ url('/newincidencia') }}" >
                                        <button class="btn btn-block btn-primary btn-sm">Incidencia Nueva</button>
                                    </a>
                                </div>
                            </div>
                        </div><!-- /.box-header -->
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover">
                                <tr>
                                    <th>Cod.</th>
                                    <th>Gerencia/Unidad</th>
                                    <th>Status</th>
                                    <th>Proyecto</th>
                                    <th>Prioridad</th>
                                    <th>Responable</th>
                                </tr>
                                @foreach($proyectos as $proyecto)
                                    {{--Escribo en PHP Plano funcion para calcular los dias en los que va el proyecto--}}
                                    <?php
                                    $ahora = new DateTime("now");
                                    $inic = new DateTime($proyecto->fecha_inicio);
                                    $fin = new DateTime($proyecto->fecha_fin);
                                    $diferencia_dias=$inic->diff($fin);
                                    $dias_transcurridos=$inic->diff($ahora)
                                    ?>

                                    @if($proyecto->tipo == "Incidencia")
                                        <tr>
                                            <td><small>{{$proyecto->codigo}}</small></td>
                                            <td>{{$proyecto->id_departamento}}</td>
                                            @if($proyecto->certificacion)
                                                <td><span class="label label-success">Certificado</span></td>
                                            @else
                                                @if($proyecto->fecha_inicio and $ahora>=$fin)
                                                    <td><span class="label label-danger">Vencido</span></td>
                                                @else
                                                    @if($proyecto->especialista)
                                                        <td><span class="label label-success">En Desarrollo</span></td>
                                                    @else
                                                        <td><span class="label label-warning">Pendiente por asignar</span></td>
                                                    @endif
                                                @endif
                                            @endif
                                            <td>{{$proyecto->nombre}}</td>
                                            <td>{{$proyecto->prioridad}}</td>
                                            <td>
                                                @foreach($ProyectEspe as $t)
                                                    @if($t->id_proyecto == $proyecto->id_proyecto)
                                                        @if($proyecto->ext_int_enum == 'interno')
                                                            @foreach($especialistas as $es)
                                                                @if($t->id_especialista == $es->id)
                                                                    <i class="fa fa-fw fa-user"></i>{{$es->nombre}}<br>
                                                                @endif
                                                            @endforeach
                                                        @else
                                                            @foreach($proveedores as $es)
                                                                @if($t->id_proveedor == $es->id_proveedor)
                                                                    <i class="fa fa-fw fa-building"></i>{{$es->nombre}}<br>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </td>
                                            <td>
                                                <a href="{{ url('editarproyecto', $proyecto) }}"><i class="fa fa-fw fa-edit"></i>Editar</a>

                                                <a href="{{ url('eliminarproyect', $proyecto) }}" onclick="return confirm('Sefuro que desea eliminar?')" class="btn-delete"><i class="fa fa-fw fa-times"></i>Eliminar</a>
                                                <a href="{{ url('comentario', $proyecto) }}"><i class="fa fa-fw fa-comment"></i>Comentar</a>
                                            </td>

                                        </tr>
                                    @endif
                                @endforeach
                            </table>
                            {!! $proyectos->render() !!}
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div>
            </div>
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

@stop
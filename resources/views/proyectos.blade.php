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
                <li><a href="#">Todos los Proyectos</a></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <div class="row">
                <div class="col-xs-12">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Proyectos Tecnologicos</h3>
                            <div class="box-tools">
                                {{--<div class="box-tools">--}}
                                    {{--<div class="input-group" style="width: 300px;">--}}
                                        {{--<input type="text" name="table_search" class="form-control input-sm pull-right" placeholder="Search">--}}
                                        {{--<div class="input-group-btn">--}}
                                            {{--<button class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                {{--<button type="button" class="btn btn-danger">Order by</button>--}}
                                {{--<button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">--}}
                                    {{--<span class="caret"></span>--}}
                                    {{--<span class="sr-only">Toggle Dropdown</span>--}}
                                {{--</button>--}}
                                {{--<ul class="dropdown-menu" role="menu">--}}
                                    {{--<li><a href="#">Status</a></li>--}}
                                    {{--<li><a href="#">Especialista</a></li>--}}
                                {{--</ul>--}}
                                <div class="btn-group">
                                    {{--{!! Form::open especialista(['route' => 'proyectos.index', 'method' => 'GET', 'class'=>'navbar-form navbar-left pull-right','role'=>'search']) !!}--}}
                                        {{--<div class="input-group">--}}
                                          {{--{!! Form::text('name', null, [ 'class' => 'form-control', 'placeholder' => 'Search']) !!}--}}
                                        {{--</div>--}}
                                        {{--<button type="submit" class="btn btn-default">Buscar</button>--}}
                                    {{--{!! Form::close() !!}--}}
                                    {{--{!! Form::open (['route' => 'proyectos.index', 'method' => 'GET', 'class'=>'navbar-form navbar-left pull-right','role'=>'search']) !!}--}}
                                    <div class="row pull-right">
                                        {{--<div class="btn-group-sm col-md-5 col-md-offset-4" role="group" aria-label="...">--}}
                                            {{--<a href="{{ url('proyectosEspe') }}" type="button" class="btn btn-default">Especialista</a>--}}
                                            {{--<a href="{{ url('proyectosStatus') }}" type="button" class="btn btn-default">Status</a>--}}
                                            {{--<a href="{{ url('proyectosFecha') }}" type="button" class="btn btn-default">Fecha</a>--}}
                                        {{--</div>--}}
                                        <div class="col-lg-3 pull-right">
                                            {!! Form::open (['route' => 'proyectos.index', 'method' => 'GET', 'class'=>'input-group pull-right','role'=>'search']) !!}
                                                {!! Form::text('name', null, [ 'class' => 'form-control', 'placeholder' => 'Nombre de Proyecto']) !!}
                                                  <span class="input-group-btn">
                                                    <button class="btn btn-default" type="submit">Buscar</button>
                                                  </span>
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
                                    {{--{!! Form::close() !!}--}}

                                    {{--<button type="button" class="btn btn-default">Ordenar por</button>--}}
                                    {{--<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">--}}
                                        {{--<span class="caret"></span>--}}
                                        {{--<span class="sr-only">Toggle Dropdown</span>--}}
                                    {{--</button>--}}
                                    {{--<ul class="dropdown-menu" role="menu">--}}
                                        {{--<li><a href="#">Especialista</a></li>--}}
                                        {{--<li><a href="#">Estatus</a></li>--}}
                                        {{--<li><a href="#">Fecha</a></li>--}}
                                    {{--</ul>--}}
                                </div>
                            </div>
                        </div><!-- /.box-header -->
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover">
                                <tr>
                                    <th>Cod.</th>
                                    <th>Tipo</th>
                                    <th>Gerencia/Unidad</th>
                                    <th>Status</th>
                                    <th>Proyecto</th>
                                    <th>Responable</th>
                                    <th>Stat</th>
                                    {{--<th></th>--}}
                                </tr>
                                @foreach($proyectos as $proyecto)
                                    {{--Escribo en PHP Plano funcion para calcular los dias en los que va el proyecto--}}
                                    <?php
                                    $ahora = new DateTime("now");
                                    $inic = new DateTime($proyecto->fecha_inicio);
                                    $fin = new DateTime($proyecto->fecha_fin);
                                    $diferencia_dias=$inic->diff($fin);
                                    $dias_transcurridos=$inic->diff($ahora);
                                    $proyecto->save();
                                    ?>

                                <tr>
                                    <td><small>{{$proyecto->codigo}}</small></td>
                                    <td>{{$proyecto->tipo}}</td>
                                    <td><small>{{$proyecto->id_departamento}}</small></td>
                                    @if($proyecto->certificacion)
                                        <td><span class="label label-success">Certificado</span></td>
                                        <?php $proyecto->id_enum_estatus='Certificado' ?>
                                    @else
                                        @if($proyecto->fecha_inicio and $ahora>=$fin)
                                            <td><small><span class="label label-danger">Vencido</span></small></td>
                                        @else
                                            @if($proyecto->especialista)
                                                <td><small><span class="label label-success">En Desarrollo</span></small></td>
                                               <?php $proyecto->id_enum_estatus='Desarrollo'?>
                                            @else
                                                <td><small><span class="label label-warning">Pendiente por asignar</span></small></td>
                                                <?php  $proyecto->id_enum_estatus='Pendiente por asignar'?>
                                            @endif
                                        @endif
                                    @endif
                                    <?php $proyecto->save() ?>
                                    <td>{{$proyecto->nombre}}</td>

                                    {{--<td>{{$proyecto->especialista}}</td>--}}
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

                                    {{--<td>{{$diferencia_dias->format('%R%a dias')}}</td>--}}
                                    @if($proyecto->fecha_inicio)
                                        @if($ahora>=$fin)
                                            <td><span class="label label-danger">Vencido</span></td>
                                        @elseif($dias_transcurridos->format('%R%a dias')>=0.75*$diferencia_dias->format('%R%a dias') and $ahora<$fin)
                                            <td>
                                                <span class="label label-warning">Por vencer</span>
                                            </td>
                                        @elseif($ahora>=$inic)
                                            <td><span class="label label-success">Activo</span></td>
                                        @endif
                                    @else
                                        <td><span class="label label-default">Sin Plan</span></td>
                                    @endif
                                    <td>
                                        <a href="{{ url('editarproyecto', $proyecto) }}"><i class="fa fa-fw fa-edit"></i>Editar</a>

                                        <a href="{{ url('eliminarproyect', $proyecto) }}" onclick="return confirm('Seguro que desea eliminar?')" class="btn-delete"><i class="fa fa-fw fa-times"></i>Eliminar</a>
                                        <a href="{{ url('comentario', $proyecto) }}"><i class="fa fa-fw fa-comment"></i>Comentar</a>
                                    </td>
                                </tr>
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


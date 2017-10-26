@extends('newhomepro')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1><i class="fa fa-pie-chart"></i>
                Reportes
                <small>Metas e Incidencias</small>
            </h1>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-lg-5 col-xs-7">
                    <!-- small box -->
                    <div class="small-box bg-aqua">
                        <div class="inner">
                            <h2>FO-UCT-05</h2>
                            <p>Registro de Incidencias</p>
                        </div>
                        <div class="icon">
                            <i class="glyphicon glyphicon-list-alt"></i>
                        </div>
                        <a data-toggle="modal" href="#FOUCT05" target="_blank" class="small-box-footer">Generar Reporte <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div><!-- ./col -->
                <div class="col-lg-5 col-xs-7">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <h2>FO-UCT-06</h2>
                            <p>Matriz de Metas Tecnologicas</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a data-toggle="modal" href="#FOUCT06" class="small-box-footer">Generar Reporte <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div><!-- ./col -->
            </div>
            <div class="row">
                <div class="col-lg-5 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-yellow">
                        <div class="inner">
                            <h2>FO-UCT-09</h2>
                            <p>Seguimiento a Proyectos por Especialista</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person"></i>
                        </div>
                        <a data-toggle="modal" href="#FOUCT09"  target="_blank" class="small-box-footer">Generar Reporte<i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div><!-- ./col -->
                <div class="col-lg-5 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-red">
                        <div class="inner">
                            <h2>FO-UCT-12</h2>
                            <p>Seguimiento a Proyecto por Proveedor</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a data-toggle="modal" href="#FOUCT12" class="small-box-footer">Generar Reporte <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                </div><!-- ./col -->
            </div>
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

                    {{--MODALS--}}
    <div id="FOUCT12" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Seguimiento a proycto por Proveedor</h4>
                </div>
                    <div class="modal-body">
                    {!! Form::open (['url'=> 'FO-UCT-12', 'method' => 'GET', 'class'=>'form-horizontal']) !!}
                        <div class="row">
                        <div class="col-xs-6">
                            {!! Form::label(null, 'Elija fecha inicio para generar reporte') !!}
                            <input type="date" class="form-control input-sm" id="fecha_inicio" name="fecha_inicio" >
                        </div>
                        <div class="col-xs-6">
                            {!! Form::label(null, 'Elija fecha fin para generar reporte') !!}
                            <input type="date" class="form-control input-sm" id="fecha_fin" name="fecha_fin" >
                        </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" target="_blank">Generar</button>
                    {!! Form::close()!!}
                    </div>
            </div>
        </div>
    </div>

    <div id="FOUCT05" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Registro de Incidencias</h4>
                </div>
                <div class="modal-body">
                    {!! Form::open (['url'=> 'FO-UCT-05', 'method' => 'GET', 'class'=>'form-horizontal']) !!}
                    <div class="row">
                        <div class="col-xs-6">
                            {!! Form::label(null, 'Elija fecha inicio para generar reporte') !!}
                            <input type="date" class="form-control input-sm" id="fecha_inicio" name="fecha_inicio" >
                        </div>
                        <div class="col-xs-6">
                            {!! Form::label(null, 'Elija fecha fin para generar reporte') !!}
                            <input type="date" class="form-control input-sm" id="fecha_fin" name="fecha_fin" >
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" target="_blank">Generar</button>
                    {!! Form::close()!!}
                </div>
            </div>
        </div>
    </div>

    <div id="FOUCT06" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Registro de Incidencias</h4>
                </div>
                <div class="modal-body">
                    {!! Form::open (['url'=> 'FO-UCT-06', 'method' => 'GET', 'class'=>'form-horizontal']) !!}
                    <div class="row">
                        <div class="col-xs-6">
                            {!! Form::label(null, 'Elija fecha inicio para generar reporte') !!}
                            <input type="date" class="form-control input-sm" id="fecha_inicio" name="fecha_inicio" >
                        </div>
                        <div class="col-xs-6">
                            {!! Form::label(null, 'Elija fecha fin para generar reporte') !!}
                            <input type="date" class="form-control input-sm" id="fecha_fin" name="fecha_fin" >
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" target="_blank">Generar</button>
                    {!! Form::close()!!}
                </div>
            </div>
        </div>
    </div>

    <div id="FOUCT09" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Seguimiento a proycto por Proveedor</h4>
                </div>
                <div class="modal-body">
                    {!! Form::open (['url'=> 'FO-UCT-09', 'method' => 'GET', 'class'=>'form-horizontal']) !!}
                    <div class="row">
                        <div class="col-xs-6">
                            {!! Form::label(null, 'Elija fecha inicio para generar reporte') !!}
                            <input type="date" class="form-control input-sm" id="fecha_inicio" name="fecha_inicio" >
                        </div>
                        <div class="col-xs-6">
                            {!! Form::label(null, 'Elija fecha fin para generar reporte') !!}
                            <input type="date" class="form-control input-sm" id="fecha_fin" name="fecha_fin" >
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" target="_blank">Generar</button>
                    {!! Form::close()!!}
                </div>
            </div>
        </div>
    </div>
@stop
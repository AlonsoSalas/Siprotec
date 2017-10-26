@extends('newhomepro')

@section('content')
    <div class="content-wrapper">
        {!! Form::open (['route'=> 'newmeta.store', 'method' => 'POST', 'class'=>'form-horizontal', 'files'=>true, 'enctype'=>'multipart/form-data']) !!}
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <!-- Content Header (Page header) -->

        <section class="content-header">
            <h1>
                Incidencia Nueva
                <small></small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Proyectos</a></li>
                <li class="active">Incidencia Nueva</li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <!-- left column -->
                <div class="col-lg-12 col-centred">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border ">
                            <i class="fa fa-fw fa-edit"></i>
                            <h3 class="box-title">Datos Basicos</h3>
                            <div class="box-tools pull-right">
                                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            </div>
                        </div><!-- /.box-header -->
                        <!-- form start -->
                        <form role="form">
                            <div class="box-body">
                                <div class="row ">
                                    <div class=" col-xs-4">
                                        {!! Form::label(null, 'Nombre:') !!}
                                        {!! Form::textarea('nombre',null, ['class'=>'form-control','rows'=>"3"] ) !!}
                                    </div>
                                    <div class="col-xs-2">
                                        {!! Form::label(null, 'Fecha de Recibido:') !!}
                                        {{--{!! Form::date('fecha_ingreso',null, ['class'=>'form-control input-sm'] ) !!}--}}
                                        <input type="date" class="form-control input-sm" id="fecha_ingreso" name="fecha_ingreso" placeholder="">
                                    </div>
                                    <div class="col-xs-3">
                                        {!! Form::label(null, 'Area Solicitante:') !!}
                                        <select class="form-control input-sm" name="id_departamento">
                                            @foreach($areas as $opcion )
                                                <option> {{$opcion->nombre}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                    <div class="col-xs-3">
                                        {!! Form::label(null, 'Prioridad:') !!}
                                        {!! Form::select('prioridad',[''=>'Seleccione Prioridad','Alta' => 'Alta','Media' => 'Media','Baja' => 'Baja'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-3 pull-right">
                                        {!! Form::select('tipo',['Incidencia'=>'Incidencia'],null,['class'=>'form-control hidden']) !!}
                                    </div>
                                </div>
                                <p class="help-block"></p>
                                <p class="help-block"></p>
                                <p class="help-block"></p>
                                <p class="help-block"></p>

                                <div class="f">
                                    <label for="exampleInputFile">Adjuntar Levantamiento</label>
                                    <input type="file" class="form-control" name="file">
                                </div>
                                {{--{!! Form::open (['route'=> 'save', 'method' => 'POST', 'accept-charset'=>'UTF-8', 'enctype'=>'multipart/form-data']) !!}--}}
                                <p class="help-block"></p>
                                <p class="help-block"></p>
                            </div><!-- /.box-body -->
                            <div class="box-footer " >
                                <button type="submit" class="btn btn-primary pull-right">Cargar Levantamiento</button>
                            </div>
                        </form>
                    </div><!-- /.box -->

                </div><!--/.col (left) -->

            </div>   <!-- /.row -->
            <div class="row">
                <!-- left column -->
                <div class="col-lg-12 col-centred">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border ">
                            <i class="fa fa-fw fa-user-plus"></i>
                            <h3 class="box-title">Asignar Especialista</h3>
                            <div class="box-tools pull-right">
                                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            </div>
                        </div><!-- /.box-header -->
                        <!-- form start -->
                        <form role="form">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-xs-3">
                                        {!! Form::label(null, 'Tipo:') !!}
                                        {!! Form::select('ext_int_enum',[''=>'Seleccione Tipo','interno' => 'Interno','externo' => 'Externo'],null,['class'=>'form-control']) !!}
                                    </div>
                                    <div class="col-xs-6">
                                        {!! Form::label(null, 'Especialista:') !!}
                                        {!! Form::select('especialista',[''=>'Seleccione Especialista',
                                                                        'Yulis Romero' => 'Yulis Romero',
                                                                        'Elias' => 'Elias',
                                                                        'Victor Valencia' => 'Victor Valencia',
                                                                        'Pedro Carreno' => 'Pedro Carreno',
                                                                        'Juan Batista' => 'Juan Batista'],null,['class'=>'form-control']) !!}
                                    </div>
                                    <div class="col-xs-3">
                                        <label></label>
                                        <button type="submit" class="btn btn-primary center-block">Asignar Especialista</button>
                                    </div>
                                </div>
                            </div><!-- /.box-body -->
                            <div class="box-footer " >
                                <button type="submit" class="btn btn-success pull-right">Asignar mas especialistas</button>
                            </div>
                        </form>
                    </div><!-- /.box -->

                </div><!--/.col (left) -->

            </div>   <!-- /.row -->
            <div class="row">
                <!-- left column -->
                <div class="col-lg-12 col-centred">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border ">
                            <i class="fa fa-fw fa-list-alt"></i>
                            <h3 class="box-title">Cargar Plan de Trabajo</h3>
                            <div class="box-tools pull-right">
                                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            </div>
                        </div><!-- /.box-header -->
                        <!-- form start -->
                        <form role="form">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <label for="exampleInputPassword1">Fecha de Inicio de Proyecto</label>
                                        <input type="date" class="form-control input-sm" id="fecha_inicio" name="fecha_inicio" placeholder="">
                                    </div>
                                    <div class="col-xs-3">
                                        <label for="exampleInputPassword1">Fecha fin de Proyecto</label>
                                        <input type="date" class="form-control input-sm" id="fecha_fin" name="fecha_fin" placeholder="">
                                    </div>
                                </div>
                                <div class="row">
                                    <p class="help-block"></p>
                                    <p class="help-block"></p>
                                </div>
                                <div class="f">
                                    <label for="exampleInputFile">Adjuntar plan de trabajo</label>
                                    <input type="file" class="form-control" name="file2">
                                </div>
                            </div><!-- /.box-body -->

                            <div class="box-footer " >
                                <button type="submit" class="btn btn-primary pull-right">Cargar Plan de Trabajo</button>
                            </div>
                        </form>
                    </div><!-- /.box -->

                </div><!--/.col (left) -->

            </div>   <!-- /.row -->
            <div class="row">
                <!-- left column -->
                <div class="col-lg-12 col-centred">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border ">
                            <i class="fa fa-fw fa-check-square"></i>
                            <h3 class="box-title">Cargar Certificado</h3>
                            <div class="box-tools pull-right">
                                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            </div>
                        </div><!-- /.box-header -->
                        <!-- form start -->
                        <form role="form">
                            <div class="box-body">
                                <div class="f">
                                    <label for="exampleInputFile">Adjuntar Certificacion</label>
                                    <input type="file" class="form-control" name="file3">
                                </div>
                            </div><!-- /.box-body -->
                            <div class="box-footer " >
                                <button type="submit" class="btn btn-primary pull-right">Cargar Certificado</button>
                            </div>
                        </form>
                    </div><!-- /.box -->

                </div><!--/.col (left) -->

            </div>
        </section><!-- /.content -->
        {!! Form::close()!!}
    </div>
@stop
@extends('newhomepro')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Especialistas
                <small>Internos</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Especialistas Internos</a></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <!-- left column -->
                <div class="col-lg-12 col-centred">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border ">
                            <i class="fa fa-fw fa-edit"></i>
                            <h3 class="box-title">Editar ESpecialista <smal>{{$especialista->nombre}}</smal></h3>
                            <div class="box-tools pull-right">
                                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            </div>
                        </div><!-- /.box-header -->
                        <!-- form start -->
                        {!! Form::model ($especialista, ['url'=> ['updateespein', $especialista], 'method' => 'PUT', 'class'=>'form-horizontal']) !!}
                            <div class="box-body">
                                <div class="row ">
                                    <div class=" col-xs-12">
                                        {!! Form::label(null, 'Nombre:') !!}
                                        {!! Form::text('nombre',null, ['class'=>'form-control','rows'=>"3"] ) !!}
                                    </div>
                                </div>
                                <div class="row ">
                                    <div class=" col-xs-12">
                                        {!! Form::label(null, 'User:') !!}
                                        {!! Form::text('name',null, ['class'=>'form-control','rows'=>"3"] ) !!}
                                    </div>
                                </div>
                                <div class="row ">
                                    <div class=" col-xs-12">
                                        {!! Form::label(null, 'Email:') !!}
                                        {!! Form::text('email',null, ['class'=>'form-control','rows'=>"3"] ) !!}
                                    </div>
                                </div>
                                <div class="row ">
                                    <div class="col-xs-12">
                                        {!! Form::label(null, 'Area:') !!}
                                        <select class="form-control input-sm" name="id_area">
                                            @foreach($areas as $opcion )
                                                @if($opcion->nombre == $cont)
                                                    <option selected="selected"> {{$opcion->nombre}}</option>
                                                @else
                                                    <option> {{$opcion->nombre}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="box-footer " >
                                    <a href="{{ url('/especialistas') }}" role="button" class="btn btn-default pull-right" >Cancelar</a>
                                    <button type="submit" class="btn btn-primary pull-right">Actualizar</button>
                                </div>
                                {!! Form::close()!!}
                            </div>
                    </div><!-- /.box -->

                </div><!--/.col (left) -->

            </div>   <!-- /.row -->
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
@stop


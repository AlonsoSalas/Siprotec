@extends('newhomepro')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Proveedores
                <small>Externos</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Proveedores Externos</a></li>
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
                            <h3 class="box-title">Editar Proveedor <smal>{{$proveedor->nombre}}</smal></h3>
                            <div class="box-tools pull-right">
                                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            </div>
                        </div><!-- /.box-header -->
                        <!-- form start -->
                        {!! Form::model ($proveedor, ['url'=> ['updateespeex', $proveedor], 'method' => 'PUT', 'class'=>'form-horizontal']) !!}
                            <div class="box-body">
                                <div class="row ">
                                    <div class="col-xs-12">
                                        {!! Form::label(null, 'Nombre:') !!}
                                        {!! Form::text('nombre',null, ['class'=>'form-control'] ) !!}
                                    </div>
                                    <div class="col-xs-12">
                                        {!! Form::label(null, 'Descripcion:') !!}
                                        {!! Form::textarea('descripcion',null, ['class'=>'form-control'] ) !!}
                                    </div>
                                    <div class="col-xs-12">
                                        {!! Form::label(null, 'Responsable:') !!}
                                        {!! Form::text('responsable',null, ['class'=>'form-control'] ) !!}
                                    </div>
                                </div>
                                <div class="box-footer " >
                                    <a href="{{ url('/proveedores') }}" role="button" class="btn btn-default pull-right" >Cancelar</a>
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


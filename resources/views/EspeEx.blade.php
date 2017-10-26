@extends('newhomepro')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1><i class="fa fa-fw fa-building"></i>
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
                <div class="col-xs-12">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Proveedores</h3>
                            <div class="box-tools">
                                <div class="input-group" style="width: 150px;">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-block btn-primary btn-sm" data-toggle="modal" data-target="#myModal">
                                        Agregar Proveedor
                                    </button>
                                </div>
                            </div>
                        </div><!-- /.box-header -->
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover">
                                <tr>
                                    <th>Nombre</th>
                                    <th>Descripcion</th>
                                    <th>Responsable</th>
                                </tr>
                                @foreach($proveedores as $prove)
                                    <tr>
                                        <td>{{$prove->nombre}}</td>
                                        <td>{{$prove->descripcion}}</td>
                                        <td>{{$prove->responsable}}</td>
                                        <td><a href="{{ url('editarespeex', $prove) }}"><i class="fa fa-fw fa-edit"></i>Editar</a></td>
                                        <td><a href="{{ url('eliminarespeex', $prove) }}" onclick="return confirm('Seguro que desea eliminar?')" class="btn-delete"><i class="fa fa-fw fa-user-times"></i></i>Eliminar</a></td>
                                @endforeach
                            </table>
                            {!! $proveedores->render() !!}
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                </div>
            </div>
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Agregar Proveedor</h4>
                </div>
                <div class="modal-body">
                    {!! Form::open (['route'=> ['agregarespeex'], 'method' => 'POST', 'class'=>'form-horizontal']) !!}
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Agregar Proveedor</button>
                    {!! Form::close()!!}
                </div>

            </div>
        </div>
    </div>

@stop


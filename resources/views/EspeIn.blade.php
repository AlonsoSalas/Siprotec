@extends('newhomepro')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

            <h1><i class="fa fa-fw fa-users"></i>
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
                <div class="col-xs-12">
                    <div class="box box-primary">
                        <div class="box-header">
                            <h3 class="box-title">Especialistas</h3>
                            <div class="box-tools">
                                <div class="input-group" style="width: 150px;">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-block btn-primary btn-sm" data-toggle="modal" data-target="#myModal">
                                        Agregar Especialista
                                    </button>
                                </div>
                            </div>
                        </div><!-- /.box-header -->
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover">
                                <tr>
                                    <th>Especialista</th>
                                    <th>User</th>
                                    <th>Area</th>
                                    <th>Email</th>
                                    {{--<th></th>--}}
                                </tr>
                                @foreach($especialistas as $espe)
                                <tr>
                                    <td>{{$espe->nombre}}</td>
                                    <td>{{$espe->name}}</td>
                                    <td>{{$espe->id_area}}</td>
                                    <td>{{$espe->email}}</td>
                                    <td><a href="{{ url('editarespein', $espe) }}"><i class="fa fa-fw fa-edit"></i>Editar</a></td>
                                    <td><a href="{{ url('eliminarespein', $espe) }}" onclick="return confirm('Seguro que desea eliminar?')" class="btn-delete"><i class="fa fa-fw fa-user-times"></i></i>Eliminar</a></td>
                                @endforeach
                            </table>
                            {!! $especialistas->render() !!}
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
                    <h4 class="modal-title" id="myModalLabel">Agregar Especialista</h4>
                </div>
                <div class="modal-body">
                    {!! Form::open (['route'=> ['agregarespein'], 'method' => 'POST', 'class'=>'form-horizontal']) !!}
                        <div class="col-xs-12">
                            {!! Form::label(null, 'Nombre:') !!}
                            {!! Form::text('nombre',null, ['class'=>'form-control'] ) !!}
                        </div>
                        <div class="col-xs-12">
                            {!! Form::label(null, 'User:') !!}
                            {!! Form::text('name',null, ['class'=>'form-control'] ) !!}
                        </div>
                        <div class="col-xs-12">
                            {!! Form::label(null, 'Email:') !!}
                            {!! Form::text('email',null, ['class'=>'form-control'] ) !!}
                        </div>
                        <div class="col-xs-12">
                            {!! Form::label(null, 'Area:') !!}
                            <select class="form-control input-sm" name="id_area">
                                @foreach($areas as $opcion )
                                    <option> {{$opcion->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Agregar Especialista</button>
                </div>
                {!! Form::close()!!}
            </div>
        </div>
    </div>

@stop


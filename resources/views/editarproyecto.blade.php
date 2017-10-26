@extends('newhomepro')

@section('content')
    <div class="content-wrapper">
        {{--{!! Form::model ($proyecto, ['route'=> ['newmeta.update', $proyecto], 'method' => 'PUT', 'class'=>'form-horizontal']) !!}--}}
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <!-- Content Header (Page header) -->
        <section class="content-header">

            <h1>
                Editar Proyecto
                <small>#: {{$proyecto->id_proyecto}}</small>
            </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li><a href="#">Proyectos</a></li>
                        <li class="active">Editar Proyecto</li>
                    </ol>
        </section>
        @if($proyecto->certificacion)
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
                            {!! Form::model ($proyecto, ['route'=> ['newmeta.update', $proyecto], 'method' => 'PUT', 'class'=>'form-horizontal','files'=>true, 'enctype'=>'multipart/form-data']) !!}
                            <div class="box-body">
                                <div class="row ">
                                    <div class=" col-xs-4">
                                        {!! Form::label(null, 'Nombre:') !!}
                                        {!! Form::textarea('nombre',null, ['class'=>'form-control','rows'=>"3", 'readonly'] ) !!}
                                    </div>
                                    <div class="col-xs-2">
                                        {!! Form::label(null, 'Fecha de Recibido:') !!}
                                        {{--{!! Form::date('fecha_ingreso',null, ['class'=>'form-control input-sm'] ) !!}--}}
                                        <input type="date" class="form-control input-sm" data-date-format="dd/mm/yyyy" id="fecha_ingreso" name="fecha_ingreso" value={{$proyecto->fecha_ingreso}} readonly>
                                    </div>
                                    <div class="col-xs-3">
                                        {!! Form::label(null, 'Area Solicitante:') !!}
                                        <select class="form-control input-sm" name="id_departamento" select="$cont" disabled>
                                            @foreach($areas as $opcion )
                                                @if($opcion->nombre == $cont)
                                                    <option selected="selected"> {{$opcion->nombre}}</option>
                                                @else
                                                    <option> {{$opcion->nombre}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-xs-3">
                                        {!! Form::label(null, 'Prioridad:') !!}
                                        {!! Form::select('prioridad',[''=>'Seleccione Prioridad','alta' => 'Alta','media' => 'Media','baja' => 'Baja'],$proyecto->prioridad,['class'=>'form-control', 'disabled']) !!}
                                    </div>
                                </div>
                                <p class="help-block"></p>
                                <p class="help-block"></p>
                                <p class="help-block"></p>
                                <p class="help-block"></p>
                                <div class="row ">
                                    <div class="f col-xs-8">
                                        @if($proyecto->levantamiento)
                                            <label for="exampleInputFile">Levantamiento Adjuntado<i class="fa fa-fw fa-check-square"></i></label>
                                            <p class="filename">  {{$proyecto->levantamiento}}</p>
                                            <a href="{{ url('descargarlev', $proyecto) }}" target="_blank"><i class="fa fa-fw fa-download"></i>Descargar</a>
                                        @else
                                            <label for="exampleInputFile">Adjuntar Levantamiento</label>
                                            <input type="file" class="form-control" name="file" disabled>
                                        @endif
                                    </div>
                                </div>
                                <div class="row ">
                                    <p class="help-block"></p>
                                    <p class="help-block"></p>
                                    <div class="f col-xs-8">
                                        @if($proyecto->tipo == 'Meta')
                                            @if($proyecto->fouct03)
                                                <label for="exampleInputFile">FO-UCT-03 Adjuntado<i class="fa fa-fw fa-check-square"></i></label>
                                                <p class="filename">  {{$proyecto->fouct03}}</p>
                                                <a href="{{ url('descargarfo', $proyecto) }}"  target="_blank"><i class="fa fa-fw fa-download"></i>Descargar</a>
                                            @else
                                                <label for="exampleInputFile">Adjuntar FO-UCT-03</label>
                                                <input type="file" class="form-control" name="file1" disabled>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                <p class="help-block"></p>
                                <p class="help-block"></p>
                                <p class="help-block"></p>
                            </div><!-- /.box-body -->
                            <div class="box-footer " >
                            </div>
                            {!! Form::close()!!}
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

                            {!! Form::model ($proyecto, ['route'=> ['newmeta.update', $proyecto], 'method' => 'PUT', 'class'=>'form-horizontal', 'files'=>true]) !!}
                            <div class="box-body">
                                <table class="table table-hover">
                                    @if($proyecto->ext_int_enum == 'interno')
                                        <tr>
                                            <th>Especialista</th>
                                            <th>Area</th>
                                            <th>User</th>
                                            <th>Email</th>
                                        </tr>
                                        @foreach($proyectoespe as $espe)
                                            <tr>
                                                @foreach($especialistas as $especia)
                                                    @if($especia->id == $espe->id_especialista)
                                                        <td>{{$especia->nombre}}</td>
                                                        <td>{{$especia->id_area}}</td>
                                                        <td>{{$especia->name}}</td>
                                                        <td>{{$especia->email}}</td>
                                                    @endif
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <th>Proveedor</th>
                                            <th>Responsable</th>
                                            <th>Contacto</th>
                                        </tr>
                                        @foreach($proyectoespe as $espe)
                                            <tr>
                                                @foreach($proveedores as $proveedor)
                                                    @if($proveedor->id_proveedor== $espe->id_proveedor)
                                                        <td>{{$proveedor->nombre}}</td>
                                                        <td>{{$proveedor->responsable}}</td>
                                                        <td>{{$proveedor->descripcion}}</td>
                                                    @endif
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    @endif

                                </table>
                            </div><!-- /.box-body -->
                            <div class="box-footer " >
                                {{--<button type="submit" class="btn btn-success pull-right">Asignar mas especialistas</button>--}}
                                {!! Form::close()!!}

                            </div>
                        </div><!-- /.box -->

                    </div><!--/.col (left) -->

                </div>   <!-- /.row -->

                @if($proyecto->ext_int_enum=="externo")

                    <div class="row">
                        <!-- left column -->
                        <div class="col-lg-12 col-centred">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header with-border ">
                                    <i class="fa fa-fw fa-file-pdf-o"></i>
                                    <h3 class="box-title">Cargar Archivos del Proveedor</h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                    </div>
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                {!! Form::model ($proyecto, ['route'=> ['newmeta.update', $proyecto], 'method' => 'PUT', 'class'=>'form-horizontal','files'=>true]) !!}
                                <div class="box-body">
                                    <div class="row ">
                                        <div class="f col-xs-8">
                                            @if($proyecto->ordencompra)
                                                <label for="exampleInputFile">Orden de Compra Adjuntado<i class="fa fa-fw fa-check-square"></i></label>
                                                <p class="filename">  {{$proyecto->ordencompra}}</p>
                                                <a href="{{ url('descargarorden', $proyecto) }}"  target="_blank"><i class="fa fa-fw fa-download"></i>Descargar</a>
                                                <a href="{{ url('eliminarorden', $proyecto) }}"><i class="fa fa-fw fa-close"></i>Eliminar</a>
                                            @else
                                                <label for="exampleInputFile">Adjuntar orden de compra</label>
                                                <input type="file" class="form-control" name="file4">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row ">
                                        <p class="help-block"></p>
                                        <p class="help-block"></p>
                                        <div class="f col-xs-8">
                                            @if($proyecto->factura)
                                                <label for="exampleInputFile">Factura Adjuntada<i class="fa fa-fw fa-check-square"></i></label>
                                                <p class="filename">  {{$proyecto->factura}}</p>
                                                <a href="{{ url('descargarfactura', $proyecto) }}"  target="_blank"><i class="fa fa-fw fa-download"></i>Descargar</a>
                                             @else
                                                <label for="exampleInputFile">Adjuntar factura</label>
                                                <input type="file" class="form-control" name="file5" disabled>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row ">
                                        <div class="f col-xs-8">
                                            @if($proyecto->informe)
                                                <label for="exampleInputFile">Informe<i class="fa fa-fw fa-check-square"></i></label>
                                                <p class="filename">  {{$proyecto->informe}}</p>
                                                <a href="{{ url('descargarinforme', $proyecto) }}"  target="_blank"><i class="fa fa-fw fa-download"></i>Descargar</a>
                                               @else
                                                <label for="exampleInputFile">Adjuntar Informe</label>
                                                <input type="file" class="form-control" name="file7" disabled>
                                            @endif
                                        </div>
                                    </div>
                                </div><!-- /.box-body -->

                                <div class="box-footer " >
                                </div>
                                {!! Form::close()!!}
                            </div><!-- /.box -->

                        </div><!--/.col (left) -->

                    </div>   <!-- /.row -->

                @endif
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
                            {!! Form::model ($proyecto, ['route'=> ['newmeta.update', $proyecto], 'method' => 'PUT', 'class'=>'form-horizontal','files'=>true]) !!}
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <label for="exampleInputPassword1">Fecha de Inicio de Proyecto</label>
                                        <input type="date"  class="form-control input-sm" id="fecha_inicio" name="fecha_inicio" value={{$proyecto->fecha_inicio}} readonly>
                                    </div>
                                    <div class="col-xs-3">
                                        <label for="exampleInputPassword1">Fecha fin de Proyecto</label>
                                        <input type="date" class="form-control input-sm" id="fecha_fin" name="fecha_fin" value={{$proyecto->fecha_fin}} readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <p class="help-block"></p>
                                    <p class="help-block"></p>
                                </div>
                                <div class="f">
                                    @if($proyecto->plantrabajo)
                                        <label for="exampleInputFile">Plan de Trabajo Adjuntado<i class="fa fa-fw fa-check-square"></i></label>
                                        <p class="filename">  {{$proyecto->plantrabajo}}</p>
                                        <a href="{{ url('descargarplan', $proyecto) }}"  target="_blank"><i class="fa fa-fw fa-download"></i>Descargar</a>
                                       @else
                                        <label for="exampleInputFile">Adjuntar plan de trabajo</label>
                                        <input type="file" class="form-control" name="file2" disabled>
                                    @endif
                                </div>
                            </div><!-- /.box-body -->

                            <div class="box-footer " >
                            </div>
                            {!! Form::close()!!}
                        </div><!-- /.box -->

                    </div><!--/.col (left) -->

                </div>   <!-- /.row -->
                <div class="row">
                    <!-- left column -->
                    <div class="col-lg-12 col-centred">
                        <!-- general form elements -->
                        <div class="box box-primary">
                            <div class="box-header with-border ">
                                <i class="fa fa-fw fa-check-square-o"></i>
                                <h3 class="box-title">Cargar Reporte de Indicadores</h3>
                                <div class="box-tools pull-right">
                                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                </div>
                            </div><!-- /.box-header -->
                            <!-- form start -->
                            {!! Form::model ($proyecto, ['route'=> ['newmeta.update', $proyecto], 'method' => 'PUT', 'class'=>'form-horizontal','files'=>true]) !!}
                            <div class="box-body">
                                <div class="f">
                                    @if($proyecto->indicadores)
                                        <label for="exampleInputFile">Certificado Adjuntado<i class="fa fa-fw fa-check-square"></i></label>
                                        <p class="filename">  {{$proyecto->indicadores}}</p>
                                        <a href="{{ url('descargarindi', $proyecto) }}"  target="_blank"><i class="fa fa-fw fa-download"></i>Descargar</a>
                                      @else
                                        <label for="exampleInputFile">Adjuntar Reporte de Indicadores</label>
                                        <input type="file" class="form-control" name="file6" disabled>
                                    @endif
                                </div>
                            </div><!-- /.box-body -->
                            <div class="box-footer " >
                            </div>
                            {!! Form::close()!!}
                        </div><!-- /.box -->
                    </div><!--/.col (left) -->
                </div>
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
                            {!! Form::model ($proyecto, ['route'=> ['newmeta.update', $proyecto], 'method' => 'PUT', 'class'=>'form-horizontal','files'=>true]) !!}
                            <div class="box-body">
                                <div class="f">
                                    @if($proyecto->certificacion)
                                        <label for="exampleInputFile">Certificado Adjuntado<i class="fa fa-fw fa-check-square"></i></label>
                                        <p class="filename">  {{$proyecto->certificacion}}</p>
                                        <a href="{{ url('descargarcer', $proyecto) }}"  target="_blank"><i class="fa fa-fw fa-download"></i>Descargar</a>
                                    @else
                                        <label for="exampleInputFile">Adjuntar Certificacio</label>
                                        <input type="file" class="form-control" name="file3" disabled>
                                    @endif
                                </div>
                            </div><!-- /.box-body -->
                            <div class="box-footer " >
                            </div>
                            {!! Form::close()!!}
                        </div><!-- /.box -->

                    </div><!--/.col (left) -->

                </div>
            </section><!-- /.content -->
            {{--{!! Form::close()!!}--}}
        @else
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
                            {!! Form::model ($proyecto, ['route'=> ['newmeta.update', $proyecto], 'method' => 'PUT', 'class'=>'form-horizontal','files'=>true, 'enctype'=>'multipart/form-data']) !!}
                            <div class="box-body">
                                <div class="row ">
                                    <div class=" col-xs-4">
                                        {!! Form::label(null, 'Nombre:') !!}
                                        {!! Form::textarea('nombre',null, ['class'=>'form-control','rows'=>"3"] ) !!}
                                    </div>
                                    <div class="col-xs-2">
                                        {!! Form::label(null, 'Fecha de Recibido:') !!}
                                        {{--{!! Form::date('fecha_ingreso',null, ['class'=>'form-control input-sm'] ) !!}--}}
                                        <input type="date" class="form-control input-sm" data-date-format="dd/mm/yyyy" id="fecha_ingreso" name="fecha_ingreso" value={{$proyecto->fecha_ingreso}}>
                                    </div>
                                    <div class="col-xs-3">
                                        {!! Form::label(null, 'Area Solicitante:') !!}
                                        <select class="form-control input-sm" name="id_departamento" select="$cont">
                                            @foreach($areas as $opcion )
                                                @if($opcion->nombre == $cont)
                                                    <option selected="selected"> {{$opcion->nombre}}</option>
                                                @else
                                                    <option> {{$opcion->nombre}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-xs-3">
                                        {!! Form::label(null, 'Prioridad:') !!}
                                        {!! Form::select('prioridad',[''=>'Seleccione Prioridad','alta' => 'Alta','media' => 'Media','baja' => 'Baja'],$proyecto->prioridad,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <p class="help-block"></p>
                                <p class="help-block"></p>
                                <p class="help-block"></p>
                                <p class="help-block"></p>
                                <div class="row ">
                                    <div class="f col-xs-8">
                                        @if($proyecto->levantamiento)
                                            <label for="exampleInputFile">Levantamiento Adjuntado<i class="fa fa-fw fa-check-square"></i></label>
                                            <p class="filename">  {{$proyecto->levantamiento}}</p>
                                            <a href="{{ url('descargarlev', $proyecto) }}" target="_blank"><i class="fa fa-fw fa-download"></i>Descargar</a>
                                            <a href="{{ url('eliminarlev', $proyecto) }}"><i class="fa fa-fw fa-close"></i>Eliminar</a>
                                        @else
                                            <label for="exampleInputFile">Adjuntar Levantamiento</label>
                                            <input type="file" class="form-control" name="file">
                                        @endif
                                    </div>
                                </div>
                                <div class="row ">
                                    <p class="help-block"></p>
                                    <p class="help-block"></p>
                                    <div class="f col-xs-8">
                                        @if($proyecto->tipo == 'Meta')
                                            @if($proyecto->fouct03)
                                                <label for="exampleInputFile">FO-UCT-03 Adjuntado<i class="fa fa-fw fa-check-square"></i></label>
                                                <p class="filename">  {{$proyecto->fouct03}}</p>
                                                <a href="{{ url('descargarfo', $proyecto) }}"  target="_blank"><i class="fa fa-fw fa-download"></i>Descargar</a>
                                                <a href="{{ url('eliminarfo', $proyecto) }}"><i class="fa fa-fw fa-close"></i>Eliminar</a>
                                            @else
                                                <label for="exampleInputFile">Adjuntar FO-UCT-03</label>
                                                <input type="file" class="form-control" name="file1">
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                <p class="help-block"></p>
                                <p class="help-block"></p>
                                <p class="help-block"></p>
                            </div><!-- /.box-body -->
                            <div class="box-footer " >
                                <button type="submit" class="btn btn-primary pull-right">Cargar Levantamiento</button>
                            </div>
                            {!! Form::close()!!}
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
                            <div class="box-body">
                                <div class ="row">
                                    <a data-toggle="modal" href="#example" class="btn btn-success btn-large" >Asignar Especialista Interno</a>
                                    <div id="example" class="modal fade">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h4 class="modal-title">Asignar Especialista</h4>
                                                </div>
                                                @if($proyecto->ext_int_enum == 'externo')
                                                    <div class="modal-body">
                                                        <div class="col-xs-6">
                                                            {!! Form::label(null, 'No puede el proyecto es Externo') !!}
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                                    </div>
                                                @else
                                                    <div class="modal-body">
                                                        {!! Form::open (['route'=> ['asignarespecialista',$proyecto->id_proyecto], 'method' => 'POST', 'class'=>'form-horizontal']) !!}
                                                        <div class="row">
                                                            <div class="col-xs-6">
                                                                {!! Form::label(null, 'Especialista:') !!}
                                                                <select class="form-control input-sm" name="especialista">
                                                                    @foreach($especialistas as $opcion )
                                                                        <option> {{$opcion->nombre}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                                        <button type="submit" class="btn btn-primary" name="objeto" value="objeto" >Asignar</button>
                                                        {!! Form::close()!!}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-md-offset-3">
                                        <a data-toggle="modal" href="#examplex" class="btn btn-success btn-large" >Asignar Proveedor Externo</a>
                                    </div>
                                    <div id="examplex" class="modal fade">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h4 class="modal-title">Asignar Proveedor Externo</h4>
                                                </div>
                                                @if($proyecto->ext_int_enum == 'interno')
                                                    <div class="modal-body">
                                                        <div class="col-xs-6">
                                                            {!! Form::label(null, 'No puede el proyecto es Interno') !!}
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                                    </div>
                                                @else
                                                    @if($proyecto->ext_int_enum == 'externo')
                                                        <div class="modal-body">
                                                            <div class="col-xs-6">
                                                                {!! Form::label(null, 'No se puden agregar mas proveedores') !!}
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                                        </div>
                                                    @else
                                                        <div class="modal-body">
                                                            {!! Form::open (['route'=> ['asignarespecialistaex',$proyecto->id_proyecto], 'method' => 'POST', 'class'=>'form-horizontal']) !!}
                                                            <div class="row">
                                                                <div class="col-xs-6">
                                                                    {!! Form::label(null, 'Proveedores:') !!}
                                                                    <select class="form-control input-sm" name="proveedores" >
                                                                        @foreach($proveedores as $opcion )
                                                                            <option> {{$opcion->nombre}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-3 col-md-offset-3">
                                                                    <a data-toggle="modal" href="#proveedornuevo" class="btn btn-default" data-dismiss="modal">Agregar Proveedor nuevo</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                                            <button type="submit" class="btn btn-primary" name="objeto" value="objeto" >Asignar</button>
                                                            {!! Form::close()!!}
                                                        </div>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div id="proveedornuevo" class="modal fade">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h4 class="modal-title">Registrar proveedor nuevo</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="col-xs-6">
                                                        {!! Form::open (['route'=> ['agregarproveedor'], 'method' => 'POST', 'class'=>'form-horizontal']) !!}
                                                        <div class="form-group">
                                                            {!! Form::label(null, 'Nombre:') !!}
                                                            {!! Form::text('nombre',null, ['class'=>'form-control'] ) !!}
                                                        </div>
                                                        <div class="form-group">
                                                            {!! Form::label(null, 'Descripcion:') !!}
                                                            {!! Form::text('descripcion',null, ['class'=>'form-control'] ) !!}
                                                        </div>
                                                        <div class="form-group">
                                                            {!! Form::label(null, 'Responsable:') !!}
                                                            {!! Form::text('responsable',null, ['class'=>'form-control'] ) !!}
                                                        </div>
                                                    </diV>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                                    <button type="submit" class="btn btn-primary" name="objeto" value="objeto">Guardar</button>
                                                    {!! Form::close()!!}
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {!! Form::model ($proyecto, ['route'=> ['newmeta.update', $proyecto], 'method' => 'PUT', 'class'=>'form-horizontal', 'files'=>true]) !!}
                            <div class="box-body">
                                <table class="table table-hover">
                                    @if($proyecto->ext_int_enum == 'interno')
                                        <tr>
                                            <th>Especialista</th>
                                            <th>Area</th>
                                            <th>User</th>
                                            <th>Email</th>
                                        </tr>
                                        @foreach($proyectoespe as $espe)
                                            <tr>
                                                @foreach($especialistas as $especia)
                                                    @if($especia->id == $espe->id_especialista)
                                                        <td>{{$especia->nombre}}</td>
                                                        <td>{{$especia->id_area}}</td>
                                                        <td>{{$especia->name}}</td>
                                                        <td>{{$especia->email}}</td>

                                                        <td><a href="{{ url('eliminarespe', $especia) }}"><i class="fa fa-fw fa-close"></i>Eliminar</a></td>
                                                    @endif
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <th>Proveedor</th>
                                            <th>Responsable</th>
                                            <th>Contacto</th>
                                        </tr>
                                        @foreach($proyectoespe as $espe)
                                            <tr>
                                                @foreach($proveedores as $proveedor)
                                                    @if($proveedor->id_proveedor== $espe->id_proveedor)
                                                        <td>{{$proveedor->nombre}}</td>
                                                        <td>{{$proveedor->responsable}}</td>
                                                        <td>{{$proveedor->descripcion}}</td>
                                                    @endif
                                                @endforeach
                                                <td><a href="{{ url('eliminarprove', $proyecto) }}"><i class="fa fa-fw fa-close"></i>Eliminar</a></td>
                                            </tr>
                                        @endforeach
                                    @endif

                                </table>
                            </div><!-- /.box-body -->
                            <div class="box-footer " >
                                {{--<button type="submit" class="btn btn-success pull-right">Asignar mas especialistas</button>--}}
                                {!! Form::close()!!}

                            </div>
                        </div><!-- /.box -->

                    </div><!--/.col (left) -->

                </div>   <!-- /.row -->

                @if($proyecto->ext_int_enum=="externo")

                    <div class="row">
                        <!-- left column -->
                        <div class="col-lg-12 col-centred">
                            <!-- general form elements -->
                            <div class="box box-primary">
                                <div class="box-header with-border ">
                                    <i class="fa fa-fw fa-file-pdf-o"></i>
                                    <h3 class="box-title">Cargar Archivos del Proveedor</h3>
                                    <div class="box-tools pull-right">
                                        <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                    </div>
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                {!! Form::model ($proyecto, ['route'=> ['newmeta.update', $proyecto], 'method' => 'PUT', 'class'=>'form-horizontal','files'=>true]) !!}
                                <div class="box-body">
                                    <div class="row ">
                                        <div class="f col-xs-8">
                                            @if($proyecto->ordencompra)
                                                <label for="exampleInputFile">Orden de Compra Adjuntado<i class="fa fa-fw fa-check-square"></i></label>
                                                <p class="filename">  {{$proyecto->ordencompra}}</p>
                                                <a href="{{ url('descargarorden', $proyecto) }}"  target="_blank"><i class="fa fa-fw fa-download"></i>Descargar</a>
                                                <a href="{{ url('eliminarorden', $proyecto) }}"><i class="fa fa-fw fa-close"></i>Eliminar</a>
                                            @else
                                                <label for="exampleInputFile">Adjuntar orden de compra</label>
                                                <input type="file" class="form-control" name="file4">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row ">
                                        <p class="help-block"></p>
                                        <p class="help-block"></p>
                                        <div class="f col-xs-8">
                                            @if($proyecto->factura)
                                                <label for="exampleInputFile">Factura Adjuntada<i class="fa fa-fw fa-check-square"></i></label>
                                                <p class="filename">  {{$proyecto->factura}}</p>
                                                <a href="{{ url('descargarfactura', $proyecto) }}"  target="_blank"><i class="fa fa-fw fa-download"></i>Descargar</a>
                                                <a href="{{ url('eliminarfactura', $proyecto) }}"><i class="fa fa-fw fa-close"></i>Eliminar</a>
                                            @else
                                                <label for="exampleInputFile">Adjuntar factura</label>
                                                <input type="file" class="form-control" name="file5">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row ">
                                        <div class="f col-xs-8">
                                            @if($proyecto->informe)
                                                <label for="exampleInputFile">Informe<i class="fa fa-fw fa-check-square"></i></label>
                                                <p class="filename">  {{$proyecto->informe}}</p>
                                                <a href="{{ url('descargarinforme', $proyecto) }}"  target="_blank"><i class="fa fa-fw fa-download"></i>Descargar</a>
                                                <a href="{{ url('eliminarinforme', $proyecto) }}"><i class="fa fa-fw fa-close"></i>Eliminar</a>
                                            @else
                                                <label for="exampleInputFile">Adjuntar Informe</label>
                                                <input type="file" class="form-control" name="file7">
                                            @endif
                                        </div>
                                    </div>
                                </div><!-- /.box-body -->

                                <div class="box-footer " >
                                    <button type="submit" class="btn btn-primary pull-right">Cargar Archivos</button>
                                </div>
                                {!! Form::close()!!}
                            </div><!-- /.box -->

                        </div><!--/.col (left) -->

                    </div>   <!-- /.row -->

                @endif
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
                            {!! Form::model ($proyecto, ['route'=> ['newmeta.update', $proyecto], 'method' => 'PUT', 'class'=>'form-horizontal','files'=>true]) !!}
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <label for="exampleInputPassword1">Fecha de Inicio de Proyecto</label>
                                        <input type="date"  class="form-control input-sm" id="fecha_inicio" name="fecha_inicio" value={{$proyecto->fecha_inicio}}>
                                    </div>
                                    <div class="col-xs-3">
                                        <label for="exampleInputPassword1">Fecha fin de Proyecto</label>
                                        <input type="date" class="form-control input-sm" id="fecha_fin" name="fecha_fin" value={{$proyecto->fecha_fin}}>
                                    </div>
                                </div>
                                <div class="row">
                                    <p class="help-block"></p>
                                    <p class="help-block"></p>
                                </div>
                                <div class="f">
                                    @if($proyecto->plantrabajo)
                                        <label for="exampleInputFile">Plan de Trabajo Adjuntado<i class="fa fa-fw fa-check-square"></i></label>
                                        <p class="filename">  {{$proyecto->plantrabajo}}</p>
                                        <a href="{{ url('descargarplan', $proyecto) }}"  target="_blank"><i class="fa fa-fw fa-download"></i>Descargar</a>
                                        <a href="{{ url('eliminarplan', $proyecto) }}"><i class="fa fa-fw fa-close"></i>Eliminar</a>
                                    @else
                                        <label for="exampleInputFile">Adjuntar plan de trabajo</label>
                                        <input type="file" class="form-control" name="file2">
                                    @endif
                                </div>
                            </div><!-- /.box-body -->

                            <div class="box-footer " >
                                <button type="submit" class="btn btn-primary pull-right">Cargar Plan de Trabajo</button>
                            </div>
                            {!! Form::close()!!}
                        </div><!-- /.box -->

                    </div><!--/.col (left) -->

                </div>   <!-- /.row -->
                <div class="row">
                    <!-- left column -->
                    <div class="col-lg-12 col-centred">
                        <!-- general form elements -->
                        <div class="box box-primary">
                            <div class="box-header with-border ">
                                <i class="fa fa-fw fa-check-square-o"></i>
                                <h3 class="box-title">Cargar Reporte de Indicadores</h3>
                                <div class="box-tools pull-right">
                                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                </div>
                            </div><!-- /.box-header -->
                            <!-- form start -->
                            {!! Form::model ($proyecto, ['route'=> ['newmeta.update', $proyecto], 'method' => 'PUT', 'class'=>'form-horizontal','files'=>true]) !!}
                            <div class="box-body">
                                <div class="f">
                                    @if($proyecto->indicadores)
                                        <label for="exampleInputFile">Certificado Adjuntado<i class="fa fa-fw fa-check-square"></i></label>
                                        <p class="filename">  {{$proyecto->indicadores}}</p>
                                        <a href="{{ url('descargarindi', $proyecto) }}"  target="_blank"><i class="fa fa-fw fa-download"></i>Descargar</a>
                                        <a href="{{ url('eliminarindi', $proyecto) }}"><i class="fa fa-fw fa-close"></i>Eliminar</a>
                                    @else
                                        <label for="exampleInputFile">Adjuntar Reporte de Indicadores</label>
                                        <input type="file" class="form-control" name="file6">
                                    @endif
                                </div>
                            </div><!-- /.box-body -->
                            <div class="box-footer " >
                                <button type="submit" class="btn btn-primary pull-right">Cargar Reporte de Indicadores</button>
                            </div>
                            {!! Form::close()!!}
                        </div><!-- /.box -->
                    </div><!--/.col (left) -->
                </div>
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
                            {!! Form::model ($proyecto, ['route'=> ['newmeta.update', $proyecto], 'method' => 'PUT', 'class'=>'form-horizontal','files'=>true]) !!}
                            <div class="box-body">
                                <div class="f">
                                    @if($proyecto->levantamiento && $proyecto->plantrabajo && $proyecto->especialista && $proyecto->indicadores)
                                        <label for="exampleInputFile">Adjuntar Certificado</label>
                                        <input type="file" class="form-control" name="file3">
                                    @else
                                        <label for="exampleInputFile"><i class="fa fa-exclamation-circle"></i>Debe completar la informacion previa para certificar</label>
                                        <input type="file" class="form-control" name="file3" disabled>
                                    @endif
                                </div>
                            </div><!-- /.box-body -->
                            <div class="box-footer " >
                                <button type="submit" class="btn btn-primary pull-right">Cargar Certificado</button>
                            </div>
                            {!! Form::close()!!}
                        </div><!-- /.box -->

                    </div><!--/.col (left) -->

                </div>
            </section><!-- /.content -->
            {{--{!! Form::close()!!}--}}
        @endif

@stop
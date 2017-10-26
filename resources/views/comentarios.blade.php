@extends('newhomepro')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Comentarios
                <small>Proyecto: {{$proyecto->nombre}}</small>
            </h1>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="col-md-12">
                @foreach($comentarios as $comentario)
                    @if($proyecto->id_proyecto == $comentario->id_proyecto)
                            <div class="box box-solid">
                                <div class="box-header with-border">
                                    <i class="fa fa-fw fa-commenting"></i>
                                    <h3 class="box-title">{{$comentario->nombre}} <small>{{$comentario->fecha}}</small></h3>
                                    <div class="pull-right box-tools">
                                        <button class="btn btn-default btn-sm" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
                                        <button class="btn btn-default btn-sm" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <blockquote>
                                        <p>{{$comentario->comentario}}</p>
                                    </blockquote>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                    @endif
                @endforeach
                    <div class="box box-success">
                        <div class="box-header with-border">
                            <h3 class="box-title">Nuevo Comentario</h3>
                        </div><!-- /.box-header -->
                        <!-- form start -->

                            <div class="box-body">
                                <div class="form-group">
                                {!! Form::open (['route'=> ['agregarcomentario',$proyecto->id_proyecto], 'method' => 'POST', 'class'=>'form-horizontal']) !!}
                                    {!! Form::textarea('comentario',null, ['class'=>'form-control','rows'=>"3"] ) !!}
                                </div>
                            </div><!-- /.box-body -->
                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary pull-right">Enviar Comentario</button>
                                {!! Form::close()!!}
                            </div>

                    </div>
            </div>

        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

@stop
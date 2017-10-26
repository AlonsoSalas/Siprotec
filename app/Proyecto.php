<?php namespace siprotec;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model {
    protected $table = 'Proyecto';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_proyecto', 'fecha_ingreso','id_enum_estatus','prioridad','especialista','tipo','nombre', 'id_departamento', 'fecha_inicio', 'fecha_fin', 'ext_int_enum', 'area','levantamiento','fouct03','plantrabajo','certificacion', 'ordencompra','factura','informe','indicadores'];

    public $timestamps = false;

    protected $primaryKey = 'id_proyecto';


    public function scopeName($query, $nombre){

        if(trim($nombre) != ""){
            $query->where('nombre', "LIKE","%$nombre%");
        }
    }
}


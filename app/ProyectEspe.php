<?php namespace siprotec;

use Illuminate\Database\Eloquent\Model;

class ProyectEspe extends Model {

    protected $table = 'proyect/espec/prove';


    protected $fillable = ['id','id_proyecto', 'id_especialista','id_proveedor'];

    protected $primaryKey = 'id';
    public $timestamps = false;

}

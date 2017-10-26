<?php namespace siprotec;

use Illuminate\Database\Eloquent\Model;

class ProyectEspe extends Model {

    protected $table = 'proyect/espec/prove';


    protected $fillable = ['id_esp_prove','id_proyecto', 'id_especialista','id_proveedor'];

    protected $primaryKey = 'id_esp_prove';
    public $timestamps = false;

}

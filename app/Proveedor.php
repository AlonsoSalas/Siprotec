<?php namespace siprotec;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model {

    protected $table = 'Proveedor';


    protected $fillable = ['id_proveedor', 'nombre', 'descripcion','responsable'];


    public $timestamps = false;
    protected $primaryKey = 'id_proveedor';

}

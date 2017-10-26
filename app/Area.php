<?php namespace siprotec;

use Illuminate\Database\Eloquent\Model;

class Area extends Model {
    protected $table = 'Area';


    protected $fillable = ['id_area', 'nombre', 'short'];


    public $timestamps = false;
    protected $primaryKey = 'id_area';
}

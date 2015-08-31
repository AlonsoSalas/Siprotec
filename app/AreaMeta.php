<?php namespace siprotec;

use Illuminate\Database\Eloquent\Model;

class AreaMeta extends Model {
    protected $table = 'area/meta';


    protected $fillable = ['id_area', 'id_meta', 'anio'];


    public $timestamps = false;
}

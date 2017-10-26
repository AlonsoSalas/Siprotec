<?php namespace siprotec;

use Illuminate\Database\Eloquent\Model;

class Observacion extends Model {

    public $timestamps = false;

    protected $table = 'Observacion';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_usuario', 'id_proyecto', 'comentario' , 'fecha','id_pase', 'nombre'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

}

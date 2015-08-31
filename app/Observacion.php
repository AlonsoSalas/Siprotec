<?php namespace siprotec;

use Illuminate\Database\Eloquent\Model;

class Observacion extends Model {

    public $timestamps = false;

    protected $table = 'uploads';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['filename', 'fecha', 'id_proyecto' , 'tipo'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

}

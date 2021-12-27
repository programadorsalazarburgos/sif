<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'tb_persona_2017';
    protected $primaryKey = 'PK_Id_Persona';
    public $timestamps = false;
}

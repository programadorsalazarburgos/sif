<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class tb_estadistica_anio extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tb_estadistica_anio';
    protected $primaryKey = 'PK_Anio';
    public $incrementing = false;
}

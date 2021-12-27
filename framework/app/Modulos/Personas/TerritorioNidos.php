<?php

namespace App\Modulos\Personas;

use Illuminate\Database\Eloquent\Model;

class TerritorioNidos extends Model
{

    protected $table = 'tb_nidos_territorios';
    protected $primaryKey= 'Pk_Id_Territorio';

    protected $fillable = [
        'Vc_Nom_Territorio',
        'In_Meta'
    ];    
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Colegio extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tb_colegios';
    protected $primaryKey = 'PK_Id_Colegio';
    protected $fillable = [
        'VC_Nom_Colegio',
        'FK_Id_Localidad',
        'VC_DANE_12',
        'TX_Zona_SDP',
        'TX_Direccion_Colegio',
        'TX_Barrio',
        'TX_Telefono',
        'TX_Correo_Colegio',
        'VC_Fecha_Inicio',
        'VC_Espacio_Atencion',
        'VC_Nom_Rector',
        'VC_Nombre_UPZ'
    ];

    public function GetOptionsColegios() {
        return Colegio::select(DB::raw("PK_Id_colegio AS value, VC_Nom_Colegio AS text"))
        ->orderBy('VC_Nom_Colegio', 'asc')
        ->get();
    }
}

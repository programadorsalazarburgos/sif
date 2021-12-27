<?php

namespace App\Modulos\Crea;

use Illuminate\Database\Eloquent\Model;
use App\Models\Options;

class Crea extends Model
{
    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = "tb_clan";
    public $timestamps = false;
    protected $primaryKey= 'PK_Id_Clan';
    protected $fillable = [
        'VC_Nom_Clan',
        'FK_Id_Localidad',
        'VC_Direccion_Clan',
        'VC_Telefono_Clan',
        'DT_Fecha_Apertura',
        'FK_Persona_Administrador',
        'VC_Nom_Administrador',
        'VC_Correo_Administrador',
        'VC_Cuadrante',
        'VC_Hospitales',
        'VC_Bomberos',
        'VC_Vencimiento_Arriendo',
        'VC_Contrato_Arriendo',
        'FK_Asistentes',
        'VC_Google_Maps',
        'TX_Auxiliares',
        'FK_Auxiliares',
        'IN_Estado',
        'FK_Lugar_Inventario'
    ];

    public function grupos(){
    	return $this->hasMany(Emprende::class, "FK_clan", "PK_Id_Clan");
    }

    public function localidad(){
    	return $this->hasOne(Options::class, "FK_Value", "PK_Id_Clan")->where("FK_Id_Parametro", 19);
    }
}

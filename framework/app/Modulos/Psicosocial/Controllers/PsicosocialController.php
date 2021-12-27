<?php

namespace App\Modulos\Psicosocial\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Validator;
use App\Modulos\Reportes\Interfaces\ConsultaReporteInterface;
use App\Modulos\Grupos\GrupoLaboratorioClan;
use App\Modulos\Grupos\GrupoLaboratorioClanClase;
use App\Modulos\Grupos\GrupoArteEscuela;
use App\Modulos\Grupos\GrupoArteEscuelaSesionClase;
use App\Modulos\Grupos\GrupoEmprendeClan;
use App\Modulos\Grupos\GrupoEmprendeClanSesionClase;
use App\Modulos\Grupos\GrupoLaboratorioClanSesionClase;
use App\Modulos\Reportes\ReporteLineaAtencion;
use App\Modulos\Psicosocial\CasoPsicosocial;
use App\Modulos\Psicosocial\SeguimientoPsicosocial;
use App\Modulos\Psicosocial\DocumentoInteres;
use App\Modulos\Parametros\ParametroDetalles;
use App\Models\Colegio;
use File;

class PsicosocialController  extends Controller
{

    public function __construct(
        //ConsultaReporteInterface $consultaReporteRepository
    )
    {
    }

    public function index()
    {

        return view('Reportes.index_informeGestion');
    }

    /**
     * Medoto para generar reporte en PDF
     *
     * @return void
     */
  
    public function getLineasEstrategicas() {        
        $data = ParametroDetalles::select('tb_parametro_detalle.PK_Id_Tabla', 'tb_parametro_detalle.VC_Descripcion')
            ->where('tb_parametro_detalle.FK_Id_Parametro',60)
            ->get();
            return ['datos' => $data]; 
    }
    public function getAreasArtisticas() {        
        $data = ParametroDetalles::select('tb_parametro_detalle.PK_Id_Tabla', 'tb_parametro_detalle.VC_Descripcion')
            ->where('tb_parametro_detalle.FK_Id_Parametro',6)
            ->get();
            return ['datos' => $data]; 
    }
    public function getCreas() {         
        $sql = DB::select("select PK_Id_Clan, VC_Nom_Clan
        FROM tb_clan");
        echo json_encode($sql);
    }
    public function getInsituciones() {        
        $data = Colegio::select('tb_colegios.PK_Id_Colegio AS value', 'tb_colegios.VC_Nom_Colegio AS text')
            ->get();
            return ['datos' => $data]; 
    }
    
    public function getTipoIdentificaciones() {        
        $data = ParametroDetalles::select('tb_parametro_detalle.PK_Id_Tabla', 'tb_parametro_detalle.VC_Descripcion')
            ->where('tb_parametro_detalle.FK_Id_Parametro',5)
            ->get();
            return ['datos' => $data]; 
    }
    public function guardarCasoPsicosocial(Request $request) 
    {
        $data = new CasoPsicosocial();
        $data->vc_nombre_reporta = $request->nombre_reporta;
        $data->vc_numero_contacto_reporta = $request->numero_reporta;
        $data->vc_correo_reporta = $request->email_reporta;
        $data->dt_fecha_reporte = $request->fecha_reporte;
        $data->vc_rol = $request->rol;
        $data->vc_nombre_completo = $request->nombre_completo_persona;
        $data->FK_parametro_detalle_tipo_identificacion = $request->tipo_identificacion;
        $data->vc_numero_identificacion = $request->numero_identificacion;
        $data->dt_fecha_nacimiento = $request->fecha_nacimiento;
        $data->vc_direccion = $request->direccion;
        $data->vc_telefono_celular = $request->telefono_celular;
        $data->FK_id_parametro_detalle_linea_estrategica = $request->linea_estrategica;
        $data->FK_id_parametro_detalle_area = $request->area_artistica;
        $data->FK_id_crea = $request->crea;
        $data->FK_id_colegio = $request->institucion;
        $data->vc_institucion_aliado = $request->institucion_aliada;
        $data->vc_nombre_completo_acudiente = $request->nombre_acudiente;
        $data->FK_parametro_detalle_tipo_identificacion_acudiente = $request->tipo_identificacion_acudiente;
        $data->vc_numero_identificacion_acudiente = $request->numero_identificacion_acudiente;
        $data->vc_telefono_celular_acudiente = $request->telefono_celular_acudiente;
        $data->tx_descripcion = $request->descripcion;
        $data->save();
     
    }
    public function getCasosSeguimientos() 
    {
        $data = CasoPsicosocial::all();
        return ['datos' => $data]; 
    }
    public function getSeguimientosDocumentos() 
    {
        $data = DocumentoInteres::all();
        return ['datos' => $data]; 
    }
    public function guardarSeguimientoPsicosocial(Request $request) 
    {    
        try {
            DB::beginTransaction();
            if ($request->file != "undefined") {
                $resultado = "psicosocial";
                $path = public_path().'/documentos/idartes/'. $resultado;
                File::makeDirectory($path, $mode = 0777, true, true);
                $fileName = "psicosocial" . '-'. $request->file->getClientOriginalName();
                $nombreCarpeta = time();
                $request->file->move(public_path('/documentos/idartes/'. $nombreCarpeta.'/'), $fileName);                
                $data = new SeguimientoPsicosocial();
                $data->FK_id_caso_psicosocial = $request->idCaso;
                $data->dt_fecha_seguimiento = $request->fechaSeguimiento;      
                $data->tx_descripcion_seguimiento = $request->descripcionSeguimiento;
                $data->vc_anexo = '/documentos/idartes/'. $nombreCarpeta.'/'.$fileName;         
                $data->vc_extension = $request->file->getClientOriginalExtension();         
                $data->save();
                DB::commit();
            }    
            
    } catch(\Illuminate\Database\QueryException $ex){
        return false;
    }     
    }
    public function guardarDocumentoPsicosocial(Request $request) 
    {    
        try {
            DB::beginTransaction();
            if ($request->file != "undefined") {
                $resultado = "psicosocialInteres";
                $path = public_path().'/documentos/idartes/'. $resultado;
                File::makeDirectory($path, $mode = 0777, true, true);
                $fileName = "psicosocialInteres" . '-'. $request->file->getClientOriginalName();
                $nombreCarpeta = time();
                $request->file->move(public_path('/documentos/idartes/'. $nombreCarpeta.'/'), $fileName);                
                $data = new DocumentoInteres();
                $data->vc_categoria = $request->categoria;
                $data->vc_anexo = '/documentos/idartes/'. $nombreCarpeta.'/'.$fileName;         
                $data->vc_extension = $request->file->getClientOriginalExtension();         
                $data->tx_descripcion = $request->descripcion;       
                $data->save();
                DB::commit();
            }    
            
    } catch(\Illuminate\Database\QueryException $ex){
        return false;
    }     
    }
    public function getSeguimientos(Request $request)
    {
        $data = SeguimientoPsicosocial::where("FK_id_caso_psicosocial", $request->casoId)->get();
        return ['datos' => $data]; 
    }
    public function cerrarActivarSeguimiento(Request $request)
    {
        $data = CasoPsicosocial::where("pk_id_caso_psicosocial", $request->id)->firstOrFail();
        $data->estado = $request->estado;
        $data->save();
        return ['datos' => true]; 
    }
    public function getReporte(Request $request)
    {
        $data = CasoPsicosocial::select(
            'pk_id_caso_psicosocial', 
            'vc_nombre_reporta', 
            'vc_numero_contacto_reporta', 
            'vc_correo_reporta', 
            'dt_fecha_reporte', 
            'vc_rol', 
            'vc_nombre_completo', 
            'vc_numero_identificacion', 
            'dt_fecha_nacimiento', 
            'vc_direccion', 
            'vc_telefono_celular', 
            'tx_descripcion'
            )->whereBetween('created_at', [$request->fechaInicio, $request->fechaFin])->get();
        return ['datos' => $data]; 
    }
}

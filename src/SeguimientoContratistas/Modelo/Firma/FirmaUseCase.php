<?php
namespace SeguimientoContratistas\Modelo\Firma;


class FirmaUseCase
{
    #Ambiente de Pruebas
    #protected $urlBase = "http://172.16.16.98";
    #protected $accesToken = "86d13965fdca37c5df1a8d9149d2c8e49d09b9b92a68dde64bf24fde5539e6be";

    #Ambiente de Producción
    protected $urlBase = "https://orfeo.idartes.gov.co/69825f31696b0849636a6cc684adb3046886028c312f6a5e2e06d037d6573665";
    protected $accesToken = "b85fc334a5169acb43bb8981086f4d4f1a5f06673b8a8385cf835730b552eb00";    

    public function request(String $tipoSolicitud,String $ruta, $datos,$json = true)
    {
        if($json){
            $headers = [
                'Authorization: Bearer '.$this->accesToken.'',
                'cache-control: no-cache',
                'Content-Type: application/json'
            ] ;         
        }else{
            $headers = [
                'Authorization: Bearer '.$this->accesToken.'',
                'cache-control: no-cache',                
            ];            
        }
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->urlBase.$ruta,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_FRESH_CONNECT=>true,
            CURLOPT_FORBID_REUSE=>true,             
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $tipoSolicitud,
            CURLOPT_POSTFIELDS =>$datos,
            CURLOPT_HTTPHEADER =>$headers,
        ));
       
        $response = curl_exec($curl);
        curl_close($curl);          
        return $response;
    }

    public function requestFiles(String $tipoSolicitud,String $ruta, $datos)
    {

        $curl = curl_init();

        curl_setopt_array($curl,[
            CURLOPT_URL => $this->urlBase.$ruta,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_FRESH_CONNECT=>true,
            CURLOPT_FORBID_REUSE=>true,              
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $tipoSolicitud,
            CURLOPT_POSTFIELDS => $datos,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer '.$this->accesToken.''
            ],            
        ]);
        
        $response = curl_exec($curl);        
        curl_close($curl);          
        return $response;
    }    
}
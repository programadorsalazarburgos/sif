@component('mail::message')
<div style="text-align: center;">
	<img src="https://sif.idartes.gov.co/sif/framework/public/images/logo_crea.png" width="130">
</div>

@if($datos->notificacion_email == "confirmacion_preinscripcion")
# ¡Solicitud realizada exitosamente!

Hola {{ $datos->primer_nombre }} {{$datos->primer_apellido}}:

Vamos a validar tu información y pronto nos pondremos en contacto para finalizar la inscripción

A continuación, encontrarás la información del grupo en el cual quieres participar.

|  |  |
|--|--|
| **Grupo:** | {{ $datos->modalidad_area}} |
| **Lugar:** | {{ $datos->lugar }} |
| **Teléfono:** | {{ $datos->telefono_lugar }} |
| **Horario:** | {{ $datos->horario }} |
| **Descripción del grupo:** | {{ $datos->descripcion }} |
@endif

@if($datos->notificacion_email == "aprobar")
# ¡Felicidades, ya eres parte del programa Crea! 

Hola {{ $datos->primer_nombre }} {{ $datos->primer_apellido }}

Nos complace informarte que tu proceso de inscripción al grupo **{{ $datos->modalidad }}** fue exitoso.

#
# Datos de contacto

|  |  |
|--|--|
| **Lugar:** | {{ $datos->crea }} - {{ $datos->direccion }}|
| **Teléfono:** | {{ $datos->telefono }} |
|||

@endif


@if($datos->notificacion_email == "rechazar")
# Lo sentimos, tu proceso de validación no fue exitoso

Hola {{ $datos->nombre }}, debido a las siguientes causa(s), tu inscripción al grupo {{ $datos->modalidad }} no pudo ser finalizada

|  |  |
|--|--|
| **Razón:** | {{ $datos->razon_rechazo->value }} |
| **Observación:** | {{ $datos->justificacion_rechazo }} |

#
# Datos de contacto

|  |  |
|--|--|
| **Lugar:** | {{ $datos->crea }} - {{ $datos->direccion }}|
| **Teléfono:** | {{ $datos->telefono }} |
|||

En el programa Crea Idartes tenemos muchas más oportunidades para tí, has clic en el botón para conocerlas.

@component('mail::button', ['url' => 'https://www.crea.gov.co/'])
Oferta disponible Crea
@endcomponent
@endif

@if($datos->notificacion_email == "crea")

Se ha realizado una solicitud para pre inscribirse al grupo **{{ $datos->id_grupo }}**, y se encuentra disponible para su revisión.

@component('mail::button', ['url' => 'https://sif.idartes.gov.co'])
Ingresar a SIF
@endcomponent
@endif

<br>
<div style="text-align: center;">
	<a href="https://www.facebook.com/creaidartes"><img src="https://sif.idartes.gov.co/sif/framework/public/images/social/facebook.png"></a>
	<a href="https://twitter.com/idartes"><img src="https://sif.idartes.gov.co/sif/framework/public/images/social/twitter.png"></a>
	<a href="https://www.instagram.com/crea.idartes"><img src="https://sif.idartes.gov.co/sif/framework/public/images/social/instagram.png"></a>
	<a href="https://www.youtube.com/channel/UCpDcYaNxu5egyDQHuW-zDaQ"><img src="https://sif.idartes.gov.co/sif/framework/public/images/social/youtube.png"></a>
</div>

Gracias,<br>
Equipo Crea Idartes
<!-- {{ config('app.name') }}  -->

@endcomponent
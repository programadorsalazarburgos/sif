@component('mail::message')
<div style="text-align: center;">
	<img src="https://sif.idartes.gov.co/sif/framework/public/images/logo_culturas_color.png" width="130">
</div>
Saludos <h2>{{ $datos->nombre }}</h2>

{!! $datos->contenido_html !!}

@component('mail::button', ['url' => 'https://sif.idartes.gov.co'])
Ingresar a SIF
@endcomponent

<br>
<div style="text-align: center;">
	<a href="https://www.facebook.com/CulturasEnComun"><img src="https://sif.idartes.gov.co/sif/framework/public/images/social/facebook.png"></a>
	<a href="https://twitter.com/idartes"><img src="https://sif.idartes.gov.co/sif/framework/public/images/social/twitter.png"></a>
	<a href="https://www.instagram.com/culturas_en_comun/"><img src="https://sif.idartes.gov.co/sif/framework/public/images/social/instagram.png"></a>
	<a href="https://www.youtube.com/user/CanalDeIdartes"><img src="https://sif.idartes.gov.co/sif/framework/public/images/social/youtube.png"></a>
</div>

Gracias,<br>
Equipo Culturas en Común - IDARTES
<!-- {{ config('app.name') }}  -->

@endcomponent
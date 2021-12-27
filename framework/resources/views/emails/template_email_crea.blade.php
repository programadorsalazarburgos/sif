@component('mail::message')
<div style="text-align: center;">
	<img src="https://sif.idartes.gov.co/sif/framework/public/images/logo_crea.png" width="130">
</div>
Saludos <h2>{{ $datos->nombre }}</h2>

{!! $datos->contenido_html !!}

@component('mail::button', ['url' => 'https://sif.idartes.gov.co'])
Ingresar a SIF
@endcomponent

<br>
<div style="text-align: center;">
	<a href="https://www.facebook.com/creaidartes"><img src="https://sif.idartes.gov.co/sif/framework/public/images/social/facebook.png"></a>
	<a href="https://twitter.com/idartes"><img src="https://sif.idartes.gov.co/sif/framework/public/images/social/twitter.png"></a>
	<a href="https://www.instagram.com/crea.idartes"><img src="https://sif.idartes.gov.co/sif/framework/public/images/social/instagram.png"></a>
	<a href="https://www.youtube.com/channel/UCpDcYaNxu5egyDQHuW-zDaQ"><img src="https://sif.idartes.gov.co/sif/framework/public/images/social/youtube.png"></a>
</div>

Gracias,<br>
Equipo CREA - IDARTES
<!-- {{ config('app.name') }}  -->

@endcomponent
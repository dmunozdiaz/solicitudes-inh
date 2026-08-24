
<div class="container">

    Estimado(a) {{ $fullname }},<br /><br />

    Este correo electrónico fue enviado en respuesta a su solicitud para restablecer su contraseña. Por favor, presione en el siguiente enlace:<br /><br />

    <a href="{{ $reset_url }}">{{ $reset_url }}</a><br /><br />

    Por razones de seguridad, este enlace sólo estará activo por {{ $expires }} hora(s). Si usted no visita el enlace dentro del tiempo señalado, tendrá que repetir los pasos para restablecer su contraseña.<br />

    Por favor no responda este mensaje que es generado automáticamente.<br />

</div>
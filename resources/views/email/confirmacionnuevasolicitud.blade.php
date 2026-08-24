<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Documento sin título</title>
</head>

<body style="background-color: #FFFFFF">
<table align="center" style="width: 590px; height: 555px;" border="0" bgcolor="#FFFFFF">
<tbody>
<tr>
<td align="center" height="551">
<div align="center"><img style="width: 225px;" align="top" src="https://solicitudes.temuco.cl/assets/media/logos/Logo-mun-tco-w500stxt.png" /></div>
<table align="center" style="width: 500px;" border="0">
<tbody>
<tr><th colspan="2" scope="col" height="28">
<div align="center"></div>
</th></tr>
<tr>
<td align="justify" height="39">
<p>Mediante este correo electr&oacute;nico confirmamos el correcto ingreso de su solicitud. A continuaci&oacute;n, se detalla la informaci&oacute;n ingresada:</p>
	
</td>
</tr>
<tr>
<td>N&deg; de solicitud: {{ $appnumbre }}</td>
</tr>
<tr>
<td>Tipo de solicitud: {{ $tipsolicitud }}</td>
</tr>
<tr>
<td>Fecha: {{ $fecharegistro }}</td>
</tr>
<tr>
<td>Nombre solicitante: {{ $nombresolicitante }}</td>
</tr>
<tr>
<td>Correo electr&oacute;nico: {{ $email }}</td>
</tr>
<tr>
<td>Tel&eacute;fono: {{ $telefono }}</td>
</tr>
<tr>
    <td>Procedencia: {{ $procedencia }}</td>
    </tr>
</tbody>
<tbody><!--@>array--> <!--@<array--></tbody>
</table>
<table align="center" style="width: 500px;" border="0">
<tbody>
<tr>
<td align="justify">Descripci&oacute;n de la solicitud: {{ $descripcion }}</td>
</tr>
</tbody>
<tbody><!--@>array--> <!--@<array--></tbody>
</table>
<p align="center"></p>
<table align="center" cellspacing="0" border="0">
<tbody>
<tr>
<td width="500">
<p align="justify"><span style="font-size: 12px;">Cuando su solicitud sea respondida, recibirá un correo electrónico de respuesta. Además, podrá realizar seguimiento al estado de la solicitud o revisar más detalles de la respuesta en https://solicitudes.temuco.cl, ingresando con su clave única. </span></p>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<p></p>
<p></p>
<p></p>
<p></p>
<p></p>
<p></p>
<p></p>
</body>

</html>
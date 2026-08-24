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
<p>Se ha registrado en el sistema una nueva solicitud ciudadana que debe revisar y responder, o poner en proceso y asignar a quien corresponda.</p>
	
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
<p align="center"><span style="font-size: 12px;">Para revisar esta solicitud, ingrese a https://solicitudes.temuco.cl/municipalidad con su RUT y contrase&ntilde;a, secci&oacute;n "Recibidas". En caso que la tarea ya no est&eacute;  disponible, implica que otro usuario la ha tomado. </span></p>
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
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>Documento sin título</title>
  </head>

  <body style="background-color: #FFFFFF">
    <table
      align="center"
      style="width: 590px; height: 555px"
      border="0"
      bgcolor="#FFFFFF"
      data-mce-style="width: 590px; height: 555px;"
    >
      <tbody>
        <tr>
          <td align="center" height="551">
            <div align="center">
              <img style="width: 225px;"
                align="top"
                src="https://solicitudes.temuco.cl/assets/media/logos/Logo-mun-tco-w500stxt.png"
                data-mce-src="https://solicitudes.temuco.cl/assets/media/logos/Logo-mun-tco-w500stxt.png"
              />
            </div>
            <table
              align="center"
              style="width: 500px"
              border="0"
              data-mce-style="width: 500px;"
            >
              <tbody>
                <tr>
                  <th colspan="2" scope="col" height="28">
                    <div align="center"><br /></div>
                  </th>
                </tr>
                <tr>
                  <td align="justify" height="39">
                    <p>
                      Usted tiene una nueva tarea en el sistema de solicitudes
                      ciudadanas, donde debe responder la solicitud ciudadana o
                      asignar a quien corresponda. Los datos de la solicitud son
                      los siguientes:
                    </p>
                  </td>
                </tr>
                <tr>
                  <td>N° de solicitud: {{ $appnumbre }}</td>
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
                  <td>Correo electrónico: {{ $email }}</td>
                </tr>
                <tr>
                  <td>Teléfono: {{ $telefono }}</td>
                </tr>
              </tbody>
              <tbody>
                <!--@>array-->
                <!--@<array-->
              </tbody>
            </table>
            <table
              align="center"
              style="width: 500px"
              border="0"
              data-mce-style="width: 500px;"
            >
              <tbody>
                <tr>
                  <td align="justify">
                    Descripción de la solicitud:{{ $descripcion }}
                  </td>
                </tr>
                <tr>
                  <td align="justify"></td>
                </tr>
                <tr>
                  <td align="justify">Fecha de asignación: {{ $fecha_asignacion }}</td>
                </tr>
              </tbody>
              <tbody>
                <!--@>array-->
                <!--@<array-->
              </tbody>
            </table>
            <p align="center"><br /></p>
            <table align="center" cellspacing="0" border="0">
              <tbody>
                <tr>
                  <td width="500">
                    <p align="center">
                      <span
                        style="font-size: 12px"
                        data-mce-style="font-size: 12px;"
                        >Para revisar esta solicitud, ingrese a
                        https://solicitudes.temuco.cl/municipalidad con su RUT y contraseña,
                        sección "Asignadas".
                      </span>
                    </p>
                  </td>
                </tr>
              </tbody>
            </table>
          </td>
        </tr>
      </tbody>
    </table>
    <p><br /></p>
    <p><br /></p>
    <p><br /></p>
    <p><br /></p>
    <p><br /></p>
    <p><br /></p>
    <p><br /></p>
  </body>
</html>

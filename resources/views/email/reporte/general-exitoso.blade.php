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
              <img style="width: 250px;"
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
                        El reporte solicitado en el Sistema de Solicitudes Ciudadanas se ha generado exitosamente. Los datos del reporte son los siguientes:
                    </p>
                  </td>
                </tr>
                <tr>
                  <td>N° de reporte: {{ $idreporte }}</td>
                </tr>
                
                    <tr>
                    <td>Fecha y hora: {{ date('d/m/Y H:i')}}</td>
                    </tr>
                <tr>
                  <td>Nombre solicitante: {{ $solicitante }}</td>
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
                        >Para descargar su reporte, ingrese a https://solicitudes.temuco.cl/municipalidad  con su clave única, y diríjase a la sección "Reportes".
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

var target = document.querySelector("#kt_body");

var blockUI = new KTBlockUI(target, {
  zIndex: 20000,
  message:
    '<div class="blockui-message"><span class="spinner-border text-primary"></span> Cargando...</div>',
});

var edit_tiposolicitud = "";
var edit_direccionfuncionario =  "";
var edit_grupopm = "";
var edit_carga = 0;
var edit_carga2 = 0;

function bloqueo() {
  blockUI.block();

  setTimeout(function() {
    blockUI.release();
  }, 1000);
}

$(document).ready(function() {
  $("#add-perfil").select2({
    placeholder: "Seleccione un Perfil",
    language: {
      noResults: function() {
        return "No se han encontrado resultados";
      },
    },
  });

  $("#add-direccion").select2({
    placeholder: "Seleccione Dirección",
    language: {
      noResults: function() {
        return "No se han encontrado resultados";
      },
    },
  });

  $("#edit-direccion").select2({
    placeholder: "Seleccione Dirección",
    language: {
      noResults: function() {
        return "No se han encontrado resultados";
      },
    },
  });

  $("#add-tiposolicitud").select2({
    placeholder: "Seleccione solicitudes a supervisar",
    language: {
      noResults: function() {
        return "No se han encontrado resultados";
      },
    },
  });

  $("#add-grupopm").select2({
    placeholder: "Seleccione Encargados de Recepción",
    language: {
      noResults: function() {
        return "No se han encontrado resultados";
      },
    },
  });

  $("#add-direccionfuncionario").select2({
    placeholder: "Seleccione solicitudes a procesar",
    language: {
      noResults: function() {
        return "No se han encontrado resultados";
      },
    },
  });

  $("#edit-tiposolicitud").select2({
    placeholder: "Seleccione solicitudes a supervisar",
    language: {
      noResults: function() {
        return "No se han encontrado resultados";
      },
    },
  });

  $("#edit-perfil").select2({
    placeholder: "Seleccione un Perfil",
    language: {
      noResults: function() {
        return "No se han encontrado resultados";
      },
    },
  });

  $("#edit-grupopm").select2({
    placeholder: "Seleccione Encargados de Recepción",
    language: {
      noResults: function() {
        return "No se han encontrado resultados";
      },
    },
  });

  $("#edit-direccionfuncionario").select2({
    placeholder: "Seleccione solicitudes a procesar",
    language: {
      noResults: function() {
        return "No se han encontrado resultados";
      },
    },
  });

  $("#add-perfil").change(function() {
    var perfil = $("#add-perfil").val();

    if (
      perfil.includes("2") == true ||
      perfil.includes("3") == true ||
      perfil.includes("4") == true
    ) {
      $("#div-direccion").removeClass("d-none");
      console.log($("#add-direccion").val());
      if ($("#add-direccion").val() != "") {
        cargaDireccion();
      }
    } else {
      cargaDireccion();

      $("#add-tiposolicitud").val("").change();
      $("#div-tipsolicitud").addClass("d-none");
      $("#add-direccionfuncionario").val("").change();
      $("#div-direccionfuncionario").addClass("d-none");

      $("#div-encargado").val("").change();
      $("#div-encargado").addClass("d-none");
      $("#div-direccion").val("").change();
      $("#div-direccion").addClass("d-none");
    }
  });

  $("#add-direccion").change(function() {
    cargaDireccion();
  });

  $("#edit-perfil").change(function() {
    var perfil = $("#edit-perfil").val();
    if(edit_carga == 0){
      edit_carga = 1;
      if (
        perfil.includes("2") == true ||
        perfil.includes("3") == true ||
        perfil.includes("4") == true
      ) {
        $("#div-edidireccion").removeClass("d-none");
       
        if ($("#edit-direccion").val() != "") {
          
          cargaDireccionEdicion(edit_tiposolicitud , edit_direccionfuncionario , edit_grupopm);
        }
      } else {
         
          cargaDireccionEdicion(edit_tiposolicitud , edit_direccionfuncionario , edit_grupopm);
        $("#edit-tiposolicitud").val("").change();
        $("#div-edittipsolicitud").addClass("d-none");
        $("#edit-direccionfuncionario").val("").change();
        $("#div-editdireccionfuncionario").addClass("d-none");
  
        $("#div-editencargado").val("").change();
        $("#div-editencargado").addClass("d-none");
        $("#div-editdireccion").val("").change();
        $("#div-editdireccion").addClass("d-none");
      }
    }else{
      edit_carga = 1;
      if (
        perfil.includes("2") == true ||
        perfil.includes("3") == true ||
        perfil.includes("4") == true
      ) {
        $("#div-editdireccion").removeClass("d-none");
       
        if ($("#edit-direccion").val() != "") {
           edit_tiposolicitud = $("#edit-tiposolicitud").val();
           edit_direccionfuncionario =  $("#edit-direccionfuncionario").val();
           edit_grupopm = $("#edit-grupopm").val();
          cargaDireccionEdicion(edit_tiposolicitud , edit_direccionfuncionario , edit_grupopm);
        }
      } else {
         edit_tiposolicitud = $("#edit-tiposolicitud").val();
           edit_direccionfuncionario =  $("#edit-direccionfuncionario").val();
           edit_grupopm = $("#edit-grupopm").val();
          cargaDireccionEdicion(edit_tiposolicitud , edit_direccionfuncionario , edit_grupopm);
        $("#edit-tiposolicitud").val("").change();
        $("#div-edittipsolicitud").addClass("d-none");
        $("#edit-direccionfuncionario").val("").change();
        $("#div-editdireccionfuncionario").addClass("d-none");
  
        $("#div-editencargado").val("").change();
        $("#div-editencargado").addClass("d-none");
        $("#div-editdireccion").val("").change();
        $("#div-editdireccion").addClass("d-none");
      }
    }
    
  });

  $("#edit-direccion").change(function() {
    if(edit_carga2 == 0){
        edit_carga2 = 1;
        cargaDireccionEdicion(edit_tiposolicitud , edit_direccionfuncionario , edit_grupopm);
    }else{
      
        edit_tiposolicitud = $("#edit-tiposolicitud").val();
         edit_direccionfuncionario =  $("#edit-direccionfuncionario").val();
         edit_grupopm = $("#edit-grupopm").val();
        cargaDireccionEdicion(edit_tiposolicitud , edit_direccionfuncionario , edit_grupopm);
    }
         
  });

  /*$("#edit-direccion").change(function() {
    var direccion = $("#edit-direccion").val();
    $.ajax({
      url: "/administracion/usuarios/encargados",
      type: "POST",
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
      },
      data: {
        direccion: direccion,
        tipousuario: 1,
      },
      success: function(data) {
        if (data.codigo == 400) {
        } else {
          var select = "";
          $.each(data.encargados, function(index, value) {
            select +=
              '<option value="' + value.id + '">' + value.name + "</option>";
          });

          $("#edit-grupopm").html(select);
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(errorThrown);
      },
    });

    $.ajax({
      url: "/administracion/usuarios/encargados",
      type: "POST",
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
      },
      data: {
        direccion: direccion,
        tipousuario: 2,
      },
      success: function(data) {
        if (data.codigo == 400) {
        } else {
          var select = "";
          $.each(data.encargados, function(index, value) {
            select +=
              '<option value="' + value.id + '">' + value.name + "</option>";
          });

          $("#edit-direccionfuncionario").html(select);
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(errorThrown);
      },
    });

    $.ajax({
      url: "/administracion/usuarios/tipsolicitudes",
      type: "POST",
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
      },
      data: {
        direccion: direccion,
      },
      success: function(data) {
        if (data.codigo == 400) {
        } else {
          var select = "";
          $.each(data.tipsolicitudes, function(index, value) {
            select +=
              '<option value="' +
              value.id +
              '">' +
              value.nombresolicitud +
              "</option>";
          });

          //$('#edit-tiposolicitud').html(select);
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(errorThrown);
      },
    });
  });*/

  $.fn.select2.defaults.set("language", "es");

  getUsuarios();

  $("#limpiar_filtros_actividades").click(function() {
    $("#nombre_actividad_filtro").val("");
    $("#tipo_filtro").val(0);
    $("#anio_actividad_filtro").val("");
    $("#tipo_actividad_filtro").val(0);

    getUsuarios("", "", "", "");
  });
});

function cargaDireccion() {
  var perfil = $("#add-perfil").val();
  var direccion = $("#add-direccion").val();
  if (direccion != "") {
    if (perfil.includes("4") == true) {
      $("#div-encargado").removeClass("d-none");
      $("#add-encargado").val("").change();
      $.ajax({
        url: "/administracion/usuarios/encargados",
        type: "POST",
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
          direccion: direccion,
          tipousuario: 1,
        },
        success: function(data) {
          if (data.codigo == 400) {
          } else {
            var select = "";
            $.each(data.encargados, function(index, value) {
              select +=
                '<option value="' + value.id + '">' + value.name + "</option>";
            });

            $("#add-grupopm").html(select);
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(errorThrown);
        },
      });
    } else {
      $("#div-encargado").addClass("d-none");
      $("#add-encargado").val("").change();
    }

    if (perfil.includes("3") == true) {
      $("#div-direccionfuncionario").removeClass("d-none");
      $("#add-direccionfuncionario").val("").change();
      $.ajax({
        url: "/administracion/usuarios/encargados",
        type: "POST",
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
          direccion: direccion,
          tipousuario: 2,
        },
        success: function(data) {
          if (data.codigo == 400) {
          } else {
            var select = "";
            $.each(data.encargados, function(index, value) {
              select +=
                '<option value="' + value.id + '">' + value.name + "</option>";
            });

            $("#add-direccionfuncionario").html(select);
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(errorThrown);
        },
      });
    } else {
      $("#div-direccionfuncionario").addClass("d-none");
      $("#add-direccionfuncionario").val("").change();
    }

    if (perfil.includes("2") == true) {
      $("#div-tipsolicitud").removeClass("d-none");
      $("#add-tipsolicitud").val("").change();
      $.ajax({
        url: "/administracion/usuarios/tipsolicitudes",
        type: "POST",
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
          direccion: direccion,
        },
        success: function(data) {
          if (data.codigo == 400) {
          } else {
            var select = "";
            $.each(data.tipsolicitudes, function(index, value) {
              select +=
                '<option value="' +
                value.id +
                '">' +
                value.nombresolicitud +
                "</option>";
            });

            $("#add-tiposolicitud").html(select);
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(errorThrown);
        },
      });
    } else {
      $("#div-tipsolicitud").addClass("d-none");
      $("#add-tipsolicitud").val("").change();
    }
  } else {
    $("#div-encargado").addClass("d-none");
    $("#add-encargado").val("").change();
    $("#div-direccionfuncionario").addClass("d-none");
    $("#add-direccionfuncionario").val("").change();
    $("#div-tipsolicitud").addClass("d-none");
    $("#add-tipsolicitud").val("").change();
  }
}


function cargaDireccionEdicion(edittiposolicitud , editdireccionfuncionario , editencargado) {
  
  var perfil = $("#edit-perfil").val();
 console.log(perfil);
  var direccion = $("#edit-direccion").val();
  console.log(direccion);
  if (direccion != "") {
    console.log("aqui 1");
    if (perfil.includes("4") == true) {
      console.log("aqui 2");
      $("#div-editencargado").removeClass("d-none");
      $("#edit-encargado").val("").change();
      $.ajax({
        url: "/administracion/usuarios/encargados",
        type: "POST",
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
          direccion: direccion,
          tipousuario: 1,
        },
        success: function(data) {
          if (data.codigo == 400) {
          } else {
            var select = "";
            $.each(data.encargados, function(index, value) {
              select +=
                '<option value="' + value.id + '">' + value.name + "</option>";
            });

            $("#edit-grupopm").html(select);
            $("#edit-grupopm").val(editencargado).change();
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(errorThrown);
        },
      });
    } else {
      console.log("aqui 3");
      $("#div-editencargado").addClass("d-none");
      $("#edit-encargado").val("").change();
    }

    if (perfil.includes("3") == true) {
      console.log("aqui 4");
      $("#div-editdireccionfuncionario").removeClass("d-none");
      $("#edit-direccionfuncionario").val("").change();
      $.ajax({
        url: "/administracion/usuarios/encargados",
        type: "POST",
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
          direccion: direccion,
          tipousuario: 2,
        },
        success: function(data) {
          if (data.codigo == 400) {
          } else {
            var select = "";
            $.each(data.encargados, function(index, value) {
              select +=
                '<option value="' + value.id + '">' + value.name + "</option>";
            });

            $("#edit-direccionfuncionario").html(select);
            
            $("#edit-direccionfuncionario").val(editdireccionfuncionario).change();
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(errorThrown);
        },
      });
    } else {
      console.log("aqui 5");
      $("#div-editdireccionfuncionario").addClass("d-none");
      $("#edit-direccionfuncionario").val("").change();
    }

    if (perfil.includes("2") == true) {
      console.log("aqui 6");
      $("#div-edittipsolicitud").removeClass("d-none");
      $("#edit-tipsolicitud").val("").change();
      $.ajax({
        url: "/administracion/usuarios/tipsolicitudes",
        type: "POST",
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
          direccion: direccion,
        },
        success: function(data) {
          if (data.codigo == 400) {
          } else {
            var select = "";
            $.each(data.tipsolicitudes, function(index, value) {
              select +=
                '<option value="' +
                value.id +
                '">' +
                value.nombresolicitud +
                "</option>";
            });

            $("#edit-tiposolicitud").html(select);
            $("#edit-tiposolicitud").val(edittiposolicitud).change();
            
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(errorThrown);
        },
      });
    } else {
      console.log("aqui 7");
      $("#div-edittipsolicitud").addClass("d-none");
      $("#edit-tipsolicitud").val("").change();
    }
  } else {
    console.log("aqui 8");
    $("#div-editencargado").addClass("d-none");
    $("#edit-encargado").val("").change();
    $("#div-editdireccionfuncionario").addClass("d-none");
    $("#edit-direccionfuncionario").val("").change();
    $("#div-edittipsolicitud").addClass("d-none");
    $("#edit-tipsolicitud").val("").change();
  }
}

function getUsuarios(nombre_actividad, tipo, anio_actividad, tipo_actividad) {
  bloqueo();

  $("#tabla_usuarios").DataTable({
    serverSide: true,
    deferRender: true,
    rowId: "id_usuario",
    destroy: true,
    lengthMenu: [15],
    dom: "rtpi",
    ajax: {
      url: "/administracion/usuarios/listusuarios",
      type: "GET",
      crossDomain: true,
      dataType: "json",
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
      },
      data: {
        filtro: $("#text_filtro").val(),
      },
    },
    columns: [
      {
        name: "id_usuario",
        data: "id_usuario",
        className: "text-center",
      },
      {
        name: "rut",
        data: "rut",
        className: "text-center",
      },
      {
        name: "nombre",
        data: "nombre",
        className: "text-center",
      },
      {
        name: "email",
        data: "email",
        className: "text-center",
      },
      {
        name: "perfil",
        data: "perfil",
        className: "text-center",
      },

      {
        name: "estado",
        data: "estado",
        className: "text-center",
      },
      {
        data: {
          id_usuario: "id_usuario",
        },
        render: function(data) {
          if (data.habilitado == true) {
            return (
              "" +
              '<button type="button" class="btn btn-light btn-hover-primary" data-toggle="tooltip"  title="Editar" onclick="usuario(' +
              data.id_usuario +
              ')">' +
              ' <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:C:wamp64wwwkeenthemes\706\themesmetronic\themehtmldemo1dist/../src/media/svg/iconsCommunicationWrite.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">' +
              '<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">' +
              '<rect x="0" y="0" width="24" height="24"/>' +
              ' <path d="M12.2674799,18.2323597 L12.0084872,5.45852451 C12.0004303,5.06114792 12.1504154,4.6768183 12.4255037,4.38993949 L15.0030167,1.70195304 L17.5910752,4.40093695 C17.8599071,4.6812911 18.0095067,5.05499603 18.0083938,5.44341307 L17.9718262,18.2062508 C17.9694575,19.0329966 17.2985816,19.701953 16.4718324,19.701953 L13.7671717,19.701953 C12.9505952,19.701953 12.2840328,19.0487684 12.2674799,18.2323597 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.701953, 10.701953) rotate(-135.000000) translate(-14.701953, -10.701953) "/>' +
              '    <path d="M12.9,2 C13.4522847,2 13.9,2.44771525 13.9,3 C13.9,3.55228475 13.4522847,4 12.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L12.9,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>' +
              "</g>" +
              "</svg>" +
              " </span>" +
              "</button>&nbsp;" +
              '<button type="button" class="btn btn-light btn-hover-primary" data-toggle="tooltip" title="Deshabilitar" onclick="deshabilitar(' +
              data.id_usuario +
              ')">' +
              '<span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:C:wamp64wwwkeenthemes\706\themesmetronic\themehtmldemo1dist/../src/media/svg/iconsCommunicationDelete-user.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">' +
              '<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">' +
              ' <polygon points="0 0 24 0 24 24 0 24"/>' +
              '<path d="M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z M21,8 L17,8 C16.4477153,8 16,7.55228475 16,7 C16,6.44771525 16.4477153,6 17,6 L21,6 C21.5522847,6 22,6.44771525 22,7 C22,7.55228475 21.5522847,8 21,8 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>' +
              ' <path d="M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" fill="#000000" fill-rule="nonzero"/>' +
              " </g>" +
              " </svg></span>" +
              "</button>"
            );
          } else {
            return (
              "" +
              '<button type="button" class="btn btn-light btn-hover-primary" data-toggle="tooltip"  title="Editar" onclick="usuario(' +
              data.id_usuario +
              ')">' +
              ' <span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:C:wamp64wwwkeenthemes\706\themesmetronic\themehtmldemo1dist/../src/media/svg/iconsCommunicationWrite.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">' +
              '<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">' +
              '<rect x="0" y="0" width="24" height="24"/>' +
              ' <path d="M12.2674799,18.2323597 L12.0084872,5.45852451 C12.0004303,5.06114792 12.1504154,4.6768183 12.4255037,4.38993949 L15.0030167,1.70195304 L17.5910752,4.40093695 C17.8599071,4.6812911 18.0095067,5.05499603 18.0083938,5.44341307 L17.9718262,18.2062508 C17.9694575,19.0329966 17.2985816,19.701953 16.4718324,19.701953 L13.7671717,19.701953 C12.9505952,19.701953 12.2840328,19.0487684 12.2674799,18.2323597 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.701953, 10.701953) rotate(-135.000000) translate(-14.701953, -10.701953) "/>' +
              '    <path d="M12.9,2 C13.4522847,2 13.9,2.44771525 13.9,3 C13.9,3.55228475 13.4522847,4 12.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L12.9,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>' +
              "</g>" +
              "</svg>" +
              " </span>" +
              "</button>&nbsp;" +
              '<button type="button" class="btn btn-light btn-hover-primary" data-toggle="tooltip" title="Habilitar" onclick="habilitar(' +
              data.id_usuario +
              ')">' +
              '<span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:C:wamp64wwwkeenthemes\706\themesmetronic\themehtmldemo1dist/../src/media/svg/iconsCommunicationAdd-user.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">' +
              ' <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">' +
              '  <polygon points="0 0 24 0 24 24 0 24"/>' +
              '  <path d="M18,8 L16,8 C15.4477153,8 15,7.55228475 15,7 C15,6.44771525 15.4477153,6 16,6 L18,6 L18,4 C18,3.44771525 18.4477153,3 19,3 C19.5522847,3 20,3.44771525 20,4 L20,6 L22,6 C22.5522847,6 23,6.44771525 23,7 C23,7.55228475 22.5522847,8 22,8 L20,8 L20,10 C20,10.5522847 19.5522847,11 19,11 C18.4477153,11 18,10.5522847 18,10 L18,8 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>' +
              '   <path d="M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z" fill="#000000" fill-rule="nonzero"/>' +
              "  </g>" +
              "</svg></span>" +
              "</button>"
            );
          }
        },

        className: "text-center",
        orderable: false,
      },
    ],
    order: [[0, "asc"]],
    language: {
      sProcessing:
        "<span class='sr-only' style='z-index: 2000'>Espere un momento...</span>",
      sLengthMenu: "Mostrar _MENU_ registros",
      sZeroRecords: "No se encontraron resultados",
      sEmptyTable: "Ningún dato disponible en esta tabla",
      sInfo:
        "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
      sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
      sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
      sInfoPostFix: "",
      sSearch: "Buscar:",
      sUrl: "",
      sInfoThousands: ",",
      sLoadingRecords: "Cargando   111 ...",
      oPaginate: {
        sFirst: "Primero",
        sLast: "Último",
        sNext: "Siguiente",
        sPrevious: "Anterior",
      },
      oAria: {
        sSortAscending:
          ": Activar para ordenar la columna de manera ascendente",
        sSortDescending:
          ": Activar para ordenar la columna de manera descendente",
      },
    },
    initComplete: function(settings, json) {},
    fnPreDrawCallback: function() {},
    fnDrawCallback: function() {
      // $('[data-toggle="tooltip"]').tooltip();
    },
  });
}

function deshabilitar(id_usuario) {
  Swal.fire({
    title: "Deshabilitar Usuaria(o)",
    text:
      "La usuaria(o) dejará de tener acceso al sistema. ¿Está seguro de continuar?",
    icon: "question",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Aceptar",
    cancelButtonText: "Cancelar",
  }).then(result => {
    if (result.value == true) {
      blockUI.block();
      $.ajax({
        url: "/administracion/usuarios/deshabilitar",
        type: "POST",
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
          id_usuario: id_usuario,
        },
        success: function(data) {
          blockUI.release();

          if (data.codigo == 400) {
            $.each(data.error, function(index, value) {
              $("#" + index).addClass("is-invalid");
              $("#" + index + "_alert").append(
                "<div data-field='tipo_documento' data-validator='notEmpty' class='fv-help-block'>" +
                  value +
                  "</div>"
              );
              $("#" + index + "_alert").css("color", "#F64E60");
            });
          } else {
            if (data.success == false) {
              Swal.fire({
                icon: "error",
                title: "Usuario Deshabilitado",
                text: data.msg,
                showConfirmButton: true,
                confirmButtonText: "Aceptar",
              });
            } else {
              Swal.fire({
                position: "top-right",
                icon: "success",
                title: "Usuario Deshabilitado",
                showConfirmButton: false,
                timer: 2000,
              });
              getUsuarios();
            }
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(errorThrown);
        },
      });
    }
  });
}

function habilitar(id_usuario) {
  Swal.fire({
    title: "Habilitar Usuario",
    text:
      "Al habbilitar al usuario este tendrá acceso al sistema. ¿Está seguro de continuar?",
    icon: "question",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Aceptar",
    cancelButtonText: "Cancelar",
  }).then(result => {
    if (result.value == true) {
      blockUI.block();
      $.ajax({
        url: "/administracion/usuarios/habilitar",
        type: "POST",
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: {
          id_usuario: id_usuario,
        },
        success: function(data) {
          blockUI.release();

          if (data.codigo == 400) {
            $.each(data.error, function(index, value) {
              $("#" + index).addClass("is-invalid");
              $("#" + index + "_alert").append(
                "<div data-field='tipo_documento' data-validator='notEmpty' class='fv-help-block'>" +
                  value +
                  "</div>"
              );
              $("#" + index + "_alert").css("color", "#F64E60");
            });
          } else {
            if (data.success == false) {
              Swal.fire({
                icon: "error",
                title: "Usuario Deshabilitado",
                text: data.msg,
                showConfirmButton: true,
                confirmButtonText: "Aceptar",
              });
            } else {
              Swal.fire({
                position: "top-right",
                icon: "success",
                title: "Usuario Habilitado",
                showConfirmButton: false,
                timer: 2000,
              });
              getUsuarios();
            }
          }
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(errorThrown);
        },
      });
    }
  });
}

function usuario(id_usuario) {
  /* KTApp.blockPage({
    overlayColor: "#000",
    opacity: "0.3",
  });*/
  blockUI.block();

  $("#datos_emprendedora").empty();
  $("#ver_emprendedora_footer").empty();

  $.ajax({
    url: "/administracion/usuarios/usuariobyid",
    type: "GET",
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
    data: {
      id_usuario: id_usuario,
    },
    success: function(data) {
      blockUI.release();
      $("#id_usuario").val(data.usuario.id_usuario);
      $("#edit-rut").val(data.usuario.rut);
      $("#edit-nombre").val(data.usuario.nombres);
      $("#edit-appaterno").val(data.usuario.appaterno);
      $("#edit-email").val(data.usuario.email);
      edit_tiposolicitud = data.usuario.tiposolicitud.split(",");
      edit_direccionfuncionario =  data.usuario.gruposfuncionario.split(",");
      edit_grupopm = data.usuario.grupospm.split(",");

       if(data.usuario.direccion != '' ){
        $("#edit-direccion").val(data.usuario.direccion.split(","));
        $("#edit-direccion").change();
        $("#div-editdireccion").removeClass("d-none");
       }else{
        $("#edit-direccion").val('');
        $("#edit-direccion").change();
        $("#div-editdireccion").addClass("d-none");
       }

       
       $("#edit-perfil").val(data.usuario.perfil.split(","));
       $("#edit-perfil").change();
      
       edit_carga = 0;
       edit_carga2 = 0;

       //cargaDireccionEdicion(data.usuario.tiposolicitud.split(",") , data.usuario.gruposfuncionario.split(",") , data.usuario.grupospm.split(","));
     
   

      $("#modal_editar_usuario").modal("show");
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log(errorThrown);
    },
  });
}

function registrarUsuario() {
  blockUI.block();

  if ($("#add-perfil").val().includes("1") == false) {
    blockUI.release();
    add();
  } else {
    $.ajax({
      url: "/administracion/usuarios/validadadmin",
      type: "POST",
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
      },
      data: {
        perfil: $("#add-perfil").val(),
      },
      success: function(data) {
        blockUI.release();
        if (data.codigo == 400) {
          $.each(data.error, function(index, value) {
            $("#" + index).addClass("is-invalid");
            $("#" + index + "_alert").append(
              "<div data-field='tipo_documento' data-validator='notEmpty' class='fv-help-block'>" +
                value +
                "</div>"
            );
            $("#" + index + "_alert").css("color", "#F64E60");
          });
        } else {
          if (data.success == true) {
            Swal.fire({
              title: "Agregar Usuario",
              text:
                "El nuevo usuario está siendo definido como administrador del sistema. ¿Está seguro de continuar?",
              icon: "question",
              showCancelButton: true,
              confirmButtonColor: "#3085d6",
              cancelButtonColor: "#d33",
              confirmButtonText: "Aceptar",
              cancelButtonText: "Cancelar",
            }).then(result => {
              if (result.value == true) {
                add();
              }
            });
          } else {
            add();
          }
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(errorThrown);
      },
    });
  }
}

function actualizacionUsuario() {
  blockUI.block();

  if ($("#edit-perfil").val().includes("1") == false) {
    blockUI.release();
    edit();
  } else {
    $.ajax({
      url: "/administracion/usuarios/validadadminedit",
      type: "POST",
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
      },
      data: {
        id_usuario: $("#id_usuario").val(),
        perfil: 1,
      },
      success: function(data) {
        blockUI.release();
        if (data.codigo == 400) {
          $.each(data.error, function(index, value) {
            $("#" + index).addClass("is-invalid");
            $("#" + index + "_alert").append(
              "<div data-field='tipo_documento' data-validator='notEmpty' class='fv-help-block'>" +
                value +
                "</div>"
            );
            $("#" + index + "_alert").css("color", "#F64E60");
          });
        } else {
          if (data.success == true) {
            Swal.fire({
              title: "Editar Usuaria(o)",
              text:
                "La usuaria(o) está siendo definida(o) como administradar(or) del sistema. ¿Está seguro de continuar?",
              icon: "question",
              showCancelButton: true,
              confirmButtonColor: "#3085d6",
              cancelButtonColor: "#d33",
              confirmButtonText: "Aceptar",
              cancelButtonText: "Cancelar",
            }).then(result => {
              if (result.value == true) {
                edit();
              }
            });
          } else {
            edit();
          }
        }
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(errorThrown);
      },
    });
  }
}

function add() {
  blockUI.block();

  $("#add-rut").removeClass("is-invalid");
  $("#add-nombre").removeClass("is-invalid");
  $("#add-appaterno").removeClass("is-invalid");

  $("#add-email").removeClass("is-invalid");
  $("#add-perfil").removeClass("is-invalid");
  $("#add-tiposolicitud").removeClass("is-invalid");
  $("#add-direccionfuncionario").removeClass("is-invalid");

  $("#add-grupopm").removeClass("is-invalid");

  $("#add-rut_alert").empty();
  $("#add-appaterno_alert").empty();
  $("#add-nombre_alert").empty();
  $("#add-email_alert").empty();
  $("#add-perfil_alert").empty();

  $("#add-tiposolicitud_alert").empty();
  $("#add-direccionfuncionario_alert").empty();
  $("#add-grupopm_alert").empty();

  $.ajax({
    url: "/administracion/usuarios/agregar",
    type: "POST",
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
    data: {
      "add-rut": $("#add-rut").val(),
      "add-nombre": $("#add-nombre").val(),
      "add-appaterno": $("#add-appaterno").val(),
      "add-email": $("#add-email").val(),
      "add-perfil": $("#add-perfil").val(),
      "add-direccion": $("#add-direccion").val(),
      "add-grupopm": $("#add-grupopm").val(),
      "add-tiposolicitud": $("#add-tiposolicitud").val(),
      "add-direccionfuncionario": $("#add-direccionfuncionario").val(),
    },
    success: function(data) {
      blockUI.release();
      if (data.codigo == 400) {
        $.each(data.error, function(index, value) {
          $("#" + index).addClass("is-invalid");

          if (value.length == 1) {
            $("#" + index + "_alert").append(
              "<div data-field='tipo_documento' data-validator='notEmpty' class='fv-help-block'>" +
                value +
                "</div>"
            );
          } else {
            var valueAux = "";
            value.forEach(element => {
              console.log(element);

              valueAux += element + "<br>";
            });
            $("#" + index + "_alert").append(
              "<div data-field='tipo_documento' data-validator='notEmpty' class='fv-help-block'>" +
                valueAux +
                "</div>"
            );
          }

          $("#" + index + "_alert").css("color", "#F64E60");
        });
      } else {
        Swal.fire({
          position: "top-right",
          icon: "success",
          title: "Usuario Registrado",
          showConfirmButton: false,
          timer: 2000,
        });

         getUsuarios();
        $("#modal_registro_usuario").modal("toggle");
        location.reload();
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log(errorThrown);
    },
  });
}

function edit() {
  blockUI.block();
  $("#edit-nombre").removeClass("is-invalid");
  $("#edit-appaterno").removeClass("is-invalid");

  $("#edit-email").removeClass("is-invalid");
  $("#edit-perfil").removeClass("is-invalid");
  $("#edit-territorio").removeClass("is-invalid");
  $("#edit-tiposolicitud").removeClass("is-invalid");
  $("#edit-direccionfuncionario").removeClass("is-invalid");

  $("#edit-appaterno_alert").empty();
  $("#edit-nombre_alert").empty();
  $("#edit-email_alert").empty();
  $("#edit-perfil_alert").empty();
  $("#edit-territorio_alert").empty();
  $("#edit-tiposolicitud_alert").empty();

  $("#edit-tiposolicitud_alert").empty();
  $("#edit-direccionfuncionario_alert").empty();

  $.ajax({
    url: "/administracion/usuarios/editar",
    type: "POST",
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
    data: {
      id_usuario: $("#id_usuario").val(),
      "edit-nombre": $("#edit-nombre").val(),
      "edit-appaterno": $("#edit-appaterno").val(),
      "edit-email": $("#edit-email").val(),
      "edit-perfil": $("#edit-perfil").val(),
      "edit-direccion": $("#edit-direccion").val(),
      "edit-grupopm": $("#edit-grupopm").val(),
      "edit-tiposolicitud": $("#edit-tiposolicitud").val(),
      "edit-direccionfuncionario": $("#edit-direccionfuncionario").val(),
    },
    success: function(data) {
      blockUI.release();
      if (data.codigo == 400) {
        $.each(data.error, function(index, value) {
          $("#" + index).addClass("is-invalid");
          $("#" + index + "_alert").append(
            "<div data-field='tipo_documento' data-validator='notEmpty' class='fv-help-block'>" +
              value +
              "</div>"
          );
          $("#" + index + "_alert").css("color", "#F64E60");
        });
      } else {
        Swal.fire({
          position: "top-right",
          icon: "success",
          title: "Usuario Editado",
          showConfirmButton: false,
          timer: 2000,
        });

        getUsuarios();
        $("#modal_editar_usuario").modal("toggle");
        location.reload();
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.log(errorThrown);
    },
  });
}

function formatRut(rut) {
  rut.value = rut.value
    .replace(/[.-]/g, "")
    .replace(/^(\d{1,2})(\d{3})(\d{3})(\w{1})$/, "$1.$2.$3-$4")
    .toUpperCase();
}

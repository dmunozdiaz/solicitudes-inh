var target = document.querySelector("#kt_block_ui_4_target");

var blockUI = new KTBlockUI(target, {
  message:
    '<div class="blockui-message"><span class="spinner-border text-primary"></span> Enviando Datos...</div>'
});

var aFiles = {};
var elemId = "kt_uppy_5";
  var id = "#" + elemId;

$(document).ready(function() {
  const XHRUpload = Uppy.XHRUpload;

  const StatusBar = Uppy.StatusBar;
  const FileInput = Uppy.FileInput;
  const Informer = Uppy.Informer;

  
  var $statusBar = $(id + " .uppy-status");
  var $uploadedList = $(id + " .uppy-list");
  var timeout;

  var uppyMin = Uppy.Core({
    debug: true,
    autoProceed: true,
    showProgressDetails: true,
    restrictions: {
      maxFileSize: 5242880, // 5mb
      maxNumberOfFiles: 5,
      minNumberOfFiles: 1
    },
    locale: Uppy.locales.es_ES
  });

  uppyMin.use(FileInput, { target: id + " .uppy-wrapper", pretty: false });
  uppyMin.use(Informer, { target: id + " .uppy-informer" });

  // demo file upload server
  // "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
  uppyMin.use(XHRUpload, {
    endpoint: "/upload-file-funcionario",
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    },
    formData: true,
    fieldName: "files"
  });

  uppyMin.use(StatusBar, {
    target: id + " .uppy-status",
    hideUploadButton: true,
    hideAfterFinish: false
  });

  $(id + " .uppy-FileInput-input")
    .addClass("uppy-input-control")
    .attr("id", elemId + "_input_control");
  $(id + " .uppy-FileInput-container").append(
    '<label class="uppy-input-label btn btn-light-primary btn-sm btn-bold" for="' +
      (elemId + "_input_control") +
      '">Adjuntar archivos</label>'
  );

  var $fileLabel = $(id + " .uppy-input-label");

  uppyMin.on("upload", function(data) {
    $fileLabel.text("Subiendo archivo...");
    $statusBar.addClass("uppy-status-ongoing");
    $statusBar.removeClass("uppy-status-hidden");
    clearTimeout(timeout);
  });

  uppy.on("upload-success", (file, response) => {
    const httpStatus = response.status; // HTTP status code
    const httpBody = response.body; // extracted response data
    aFiles[file.id] = httpBody.id;

    // do something with file and response
  });

  uppyMin.on("complete", function(file, response) {
    $.each(file.successful, function(index, value) {
      var sizeLabel = "bytes";
      var filesize = value.size;
      if (filesize > 1024) {
        filesize = filesize / 1024;
        sizeLabel = "kb";

        if (filesize > 1024) {
          filesize = filesize / 1024;
          sizeLabel = "MB";
        }
      }
      var uploadListHtml =
        '<div class="uppy-list-item" data-id="' +
        value.id +
        '"><div class="uppy-list-label">' +
        value.name +
        " (" +
        Math.round(filesize, 2) +
        " " +
        sizeLabel +
        ')</div><span class="uppy-list-remove" data-id="' +
        value.id +
        '"<span class="svg-icon svg-icon-primary svg-icon-2x"><!--begin::Svg Icon | path:/var/www/preview.keenthemes.com/metronic/releases/2021-05-14-112058/theme/html/demo1/dist/../src/media/svg/icons/Home/Trash.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><path d="M6,8 L18,8 L17.106535,19.6150447 C17.04642,20.3965405 16.3947578,21 15.6109533,21 L8.38904671,21 C7.60524225,21 6.95358004,20.3965405 6.89346498,19.6150447 L6,8 Z M8,10 L8.45438229,14.0894406 L15.5517885,14.0339036 L16,10 L8,10 Z" fill="#000000" fill-rule="nonzero"/><path d="M14,4.5 L14,3.5 C14,3.22385763 13.7761424,3 13.5,3 L10.5,3 C10.2238576,3 10,3.22385763 10,3.5 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"/></g></svg><!--end::Svg Icon--></span></div>';
      $uploadedList.append(uploadListHtml);
    });

    $fileLabel.text("Agregar más archivos");

    $statusBar.addClass("uppy-status-hidden");
    $statusBar.removeClass("uppy-status-ongoing");
  });

  $("#kt_modal_new_target").on("shown.bs.modal", function(e) {
    var idsol = $(e.relatedTarget).data("idsolicitud");
    $("#idsolicitud").val(idsol);
    $("#modal-subtitle").html($(e.relatedTarget).data("subtitle"));

    $("#solicitante").removeClass("is-invalid");
    $("#rut").removeClass("is-invalid");

    $("#procedencia").removeClass("is-invalid");

    $("#email").removeClass("is-invalid");
    $("#telefono").removeClass("is-invalid");
    $("#descripcion").removeClass("is-invalid");

    $("#solicitante").val("");
    $("#rut").val("");
    $("#procedencia").val("");
    $("#email").val("");
    $("#telefono").val("");

    $("#descripcion").val("");
    uppyMin.reset();
    $(".uppy-list").html("");
    aFiles = {};
    var $fileLabel = $(id + " .uppy-input-label");
    $fileLabel.text("Adjuntar archivos");
  });

  $(document).on("click", id + " .uppy-list .uppy-list-remove", function() {
    var itemId = $(this).attr("data-id");
    delete aFiles[itemId];
    uppyMin.removeFile(itemId);
    $(id + ' .uppy-list-item[data-id="' + itemId + '"').remove();
  });

  $("#kt_enviar_solicitud").click(function() {
    enviar_solictud(aFiles);
  });

  $("#kt_modal_new_target_cancel").click(function() {
    $("#kt_modal_new_target").modal("hide");
  });

  $("#kt_uppy_5_input_control").hide();
});

function buscarRut() {
  $("#rut").removeClass("is-invalid");
  $("#rut_alert").empty();

  if ($("#rut").val() != "") {
    blockUI.block();
    $.ajax({
      url: "/buscar_rut",
      type: "POST",
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      data: {
        rut: $("#rut").val()
      },
      success: function(data) {
        blockUI.release();
        console.log(data);

        $("#email").val(data.user.email);
        $("#telefono").val(data.user.telefono);
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(errorThrown);
        if (jqXHR.responseJSON.message == "The given data was invalid.") {
          $.each(jqXHR.responseJSON.errors, function(index, value) {
            $("#" + index + "_alert").html("");
            $("#" + index).addClass("is-invalid");
            $("#" + index + "_alert").append(
              "<div data-field='tipo_documento' data-validator='notEmpty' class='fv-help-block'>" +
                value[0] +
                "</div>"
            );
            $("#" + index + "_alert").css("color", "#F64E60");
          });
          $("#email").val("");
          $("#telefono").val("");
        }
        blockUI.release();
      }
    });
  }
}

function enviar_solictud(aFiles) {
  blockUI.block();

  $("#solicitante").removeClass("is-invalid");
  $("#rut").removeClass("is-invalid");
  $("#email").removeClass("is-invalid");
  $("#telefono").removeClass("is-invalid");
  $("#procedencia").removeClass("is-invalid");
  $("#descripcion").removeClass("is-invalid");

  $("#solicitante_alert").empty();
  $("#rut_alert").empty();
  $("#email_alert").empty();
  $("#telefono_alert").empty();
  $("#procedencia_alert").empty();
  $("#descripcion_alert").empty();

  $.ajax({
    url: "/agregar-solicitud-supervisor",
    type: "POST",
    dataType: "json",
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    },
    data: {
      solicitante: $("#solicitante").val(),
      rut: $("#rut").val(),
      email: $("#email").val(),
      telefono: $("#telefono").val(),
      procedencia: $("#procedencia").val(),
      descripcion: $("#descripcion").val(),
      idsolicitud: $("#idsolicitud").val(),

      filesUpload: aFiles
    },
    success: function(data) {
      blockUI.release();

      if (data.codigo == 400) {
        $.each(data.error, function(index, value) {
          $("#" + index + "_alert").html("");
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
          position: "center",
          icon: "success",
          title: "¡Solicitud enviada con éxito!",
          html: "Se ha generado el ticket Nº " + data.numerosolicitud,
          showConfirmButton: true
        });

        $("#kt_modal_new_target").modal("toggle");
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      if (jqXHR.responseJSON.message == "The given data was invalid.") {
        $.each(jqXHR.responseJSON.errors, function(index, value) {
          $("#" + index + "_alert").html("");
          $("#" + index).addClass("is-invalid");
          $("#" + index + "_alert").append(
            "<div data-field='tipo_documento' data-validator='notEmpty' class='fv-help-block'>" +
              value[0] +
              "</div>"
          );
          $("#" + index + "_alert").css("color", "#F64E60");
        });
      }
      blockUI.release();
    }
  });
}

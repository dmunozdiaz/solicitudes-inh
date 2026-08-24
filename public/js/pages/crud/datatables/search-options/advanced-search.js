"use strict";
var KTDatatablesSearchOptionsAdvancedSearch = function() {

    $.fn.dataTable.Api.register('column().title()', function() {
        return $(this.header()).text().trim();
    });

    var initTableRegEmprendedora = function() {
        // begin first table
        var table = $('#kt_table_regemprendedora').DataTable({
            responsive: true,
            // Pagination settings
            dom: `<'row'<'col-sm-12'tr>>
			<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
            // read more: https://datatables.net/examples/basic_init/dom.html

            lengthMenu: [5, 15, 25, 50],

            pageLength: 15,

            language: {
                'lengthMenu': 'Display _MENU_',
            },

            searchDelay: 500,
            processing: true,
            serverSide: true,
            ajax: {
                url: HOST_URL + '/api//datatables/demos/server.php',
                type: 'POST',
                data: {
                    // parameters for custom backend script demo
                    columnsDef: [
                        'RecordID', 'OrderID', 'Country', 'ShipCity', 'CompanyAgent', 'Status', 'Actions',],
                },
            },
            columns: [
                {data: 'RecordID'},
                {data: 'OrderID'},
                {data: 'Country'},
                {data: 'ShipCity'},
                {data: 'CompanyAgent'},
                {data: 'Status'},
                {data: 'Actions', responsivePriority: -1},
            ],

            initComplete: function() {
                this.api().columns().every(function() {
                    var column = this;

                    switch (column.title()) {
                        case 'Country':
                            column.data().unique().sort().each(function(d, j) {
                                $('.datatable-input[data-col-index="2"]').append('<option value="' + d + '">' + d + '</option>');
                            });
                            break;

                        case 'Status':
                            var status = {
                                1: {'title': 'Pending', 'class': 'label-light-primary'},
                                2: {'title': 'Delivered', 'class': ' label-light-danger'},
                                3: {'title': 'Canceled', 'class': ' label-light-primary'},
                                4: {'title': 'Success', 'class': ' label-light-success'},
                                5: {'title': 'Info', 'class': ' label-light-info'},
                                6: {'title': 'Danger', 'class': ' label-light-danger'},
                                7: {'title': 'Warning', 'class': ' label-light-warning'},
                            };
                            column.data().unique().sort().each(function(d, j) {
                                $('.datatable-input[data-col-index="6"]').append('<option value="' + d + '">' + status[d].title + '</option>');
                            });
                            break;

                        case 'Type':
                            var status = {
                                1: {'title': 'Online', 'state': 'danger'},
                                2: {'title': 'Retail', 'state': 'primary'},
                                3: {'title': 'Direct', 'state': 'success'},
                            };
                            column.data().unique().sort().each(function(d, j) {
                                $('.datatable-input[data-col-index="7"]').append('<option value="' + d + '">' + status[d].title + '</option>');
                            });
                            break;
                    }
                });
            },

            columnDefs: [
                {
                    targets: -1,
                    title: 'Acciones',
                    orderable: false,
                    render: function(data, type, full, meta) {
                        return '\
							<a href="javascript:;" class="btn btn-light btn-hover-primary" title="Ver detalles" data-toggle="modal" data-target="#modal_detalle_emprendedora">\
								<span class="svg-icon svg-icon-primary svg-icon-2x">\
  								<!--begin::Svg Icon | path:../src/media/svg/icons/Communication/Adress-book2.svg-->\
                  <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">\
                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">\
                      <rect x="0" y="0" width="24" height="24"/>\
                      <path d="M18,2 L20,2 C21.6568542,2 23,3.34314575 23,5 L23,19 C23,20.6568542 21.6568542,22 20,22 L18,22 L18,2 Z" fill="#000000" opacity="0.3"/>\
                      <path d="M5,2 L17,2 C18.6568542,2 20,3.34314575 20,5 L20,19 C20,20.6568542 18.6568542,22 17,22 L5,22 C4.44771525,22 4,21.5522847 4,21 L4,3 C4,2.44771525 4.44771525,2 5,2 Z M12,11 C13.1045695,11 14,10.1045695 14,9 C14,7.8954305 13.1045695,7 12,7 C10.8954305,7 10,7.8954305 10,9 C10,10.1045695 10.8954305,11 12,11 Z M7.00036205,16.4995035 C6.98863236,16.6619875 7.26484009,17 7.4041679,17 C11.463736,17 14.5228466,17 16.5815,17 C16.9988413,17 17.0053266,16.6221713 16.9988413,16.5 C16.8360465,13.4332455 14.6506758,12 11.9907452,12 C9.36772908,12 7.21569918,13.5165724 7.00036205,16.4995035 Z" fill="#000000"/>\
                    </g>\
                  </svg><!--end::Svg Icon-->\
                </span>\
                <span>Ver</span>\
							</a>\
						';
                    },
                },
                {
                    targets: 5,
                    render: function(data, type, full, meta) {
                        var status = {
                            1: {'title': 'Inscrita', 'class': 'label-light-primary'},
                            2: {'title': 'Participando', 'class': ' label-light-danger'},
                            3: {'title': 'Egresada', 'class': ' label-light-primary'},
                            4: {'title': 'Inscrita', 'class': 'label-light-primary'},
                            5: {'title': 'Participando', 'class': ' label-light-danger'},
                            6: {'title': 'Egresada', 'class': ' label-light-primary'},
                        };
                        if (typeof status[data] === 'undefined') {
                            return data;
                        }
                        return '<span class="label label-lg font-weight-bold' + status[data].class + ' label-inline">' + status[data].title + '</span>';
                    },
                },
                /*{
                    targets: 6,
                    render: function(data, type, full, meta) {
                        var status = {
                            1: {'title': 'Inscrita', 'state': 'danger'},
                            2: {'title': 'Participando', 'state': 'primary'},
                            3: {'title': 'Egresada', 'state': 'success'},
                        };
                        if (typeof status[data] === 'undefined') {
                            return data;
                        }
                        return '<span class="label label-' + status[data].state + ' label-dot mr-2"></span>' +
                            '<span class="font-weight-bold text-' + status[data].state + '">' + status[data].title + '</span>';
                    },
                },*/
            ],
        });

        var filter = function() {
            var val = $.fn.dataTable.util.escapeRegex($(this).val());
            table.column($(this).data('col-index')).search(val ? val : '', false, false).draw();
        };

        var asdasd = function(value, index) {
            var val = $.fn.dataTable.util.escapeRegex(value);
            table.column(index).search(val ? val : '', false, true);
        };

        $('#kt_search').on('click', function(e) {
            e.preventDefault();
            var params = {};
            $('.datatable-input').each(function() {
                var i = $(this).data('col-index');
                if (params[i]) {
                    params[i] += '|' + $(this).val();
                }
                else {
                    params[i] = $(this).val();
                }
            });
            $.each(params, function(i, val) {
                // apply search params to datatable
                table.column(i).search(val ? val : '', false, false);
            });
            table.table().draw();
        });

        $('#kt_reset').on('click', function(e) {
            e.preventDefault();
            $('.datatable-input').each(function() {
                $(this).val('');
                table.column($(this).data('col-index')).search('', false, false);
            });
            table.table().draw();
        });

        $('#kt_datepicker').datepicker({
            todayHighlight: true,
            templates: {
                leftArrow: '<i class="la la-angle-left"></i>',
                rightArrow: '<i class="la la-angle-right"></i>',
            },
        });

    };

    return {

        //main function to initiate the module
        init: function() {
            initTableRegEmprendedora();
        },

    };

}();

jQuery(document).ready(function() {
    KTDatatablesSearchOptionsAdvancedSearch.init();
});

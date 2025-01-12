"use strict";
var KTDatatables = function() {

	var initTable = function() {
        var showAct = false;
        if(jv_update=='true' || jv_delete=='true' ){
            showAct = true;
        }
		var table = $('#tbl_order');

		// begin first table
		table.DataTable({
			"language": {
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                },
                "emptyTable": "Data Kosong",
                "info": "Menampilkan _START_ s/d _END_ ( Total :  _TOTAL_ data)",
                "infoEmpty": "Data tidak ditemukan",
                "infoFiltered": "(filtered1 data _MAX_ total data)",
                "lengthMenu": "Menampilkan _MENU_ data",
                "search": "Cari:",
                "zeroRecords": "Data tidak ditemukan"
            },
            /*"order": [
                [1, 'asc']
            ],*/
            "lengthMenu": [
                [25, 50, 100, -1],
                [25, 50, 100, "Semua"] // change per page values here
            ],
            "pageLength": 25,
            "dom": "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable
            "tableTools": {
                "sSwfPath": "../../assets/global/plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
                "aButtons": [{
                    "sExtends": "pdf",
                    "sButtonText": "PDF"
                }, {
                    "sExtends": "csv",
                    "sButtonText": "CSV"
                }, {
                    "sExtends": "xls",
                    "sButtonText": "Excel"
                }, {
                    "sExtends": "copy",
                    "sButtonText": "Copy"
                }]
            },
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "/orders/list",
                "type": "GET",
                "data" : function(d){
                   d.submenu=submenu;
                }
            },
            "columns": [
                {
                    "data": "id",
                    "width": "50px",
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                { "data": "nama_nasabah" },
                { 
                    "data": "tanggal_order",
                    render: function (data, type, row, meta) {
                        return tanggalIndo(data);
                    }
                 },
                { 
                    "data": "invoice" ,
                    render: function (data, type, row, meta) {
                        return viewThousandsSeparator(data);
                    }

                },
                { 
                    "data": "pengeluaran",
                    render: function (data, type, row, meta) {
                        return viewThousandsSeparator(data);
                    }
                },
                { "data": "jenis_order.name" },
                { "data": "tahapan_proses.name" },
                { "data": "progres" },
                { "data": "kendala" },
                { "data": "keterangan" },
                {
                    "data": "id",
                    "className": "text-center",
                    "width": "80px",
                    //"visible":showAct,
                    "orderable" : false,
                    render: function (data, type, row, meta) {
                        var aksi = '';
                        
                        if(jv_update=='true'){
                            aksi += '<a href="javascript:;" data-toggle="modal" data-target="#ModalFormProses" class="btn btn-sm btn-clean btn-icon mr-2 btn_update_tahapan_proses" uid="'+data+'" data-toggle="toopltip" title="Update tahapan Proses" data-html="true" data-content="">'+
                            '<i class="fas fa-clipboard-check"></i>'+   
                           '</a>';
                            aksi += '<a href="javascript:;" data-toggle="modal" data-target="#ModalFormOrder" class="btn btn-sm btn-clean btn-icon mr-2 btn_edit_order" uid="'+data+'" data-toggle="popover" title="Ubah Data" data-html="true" data-content="">'+
                                 '<i class="fa fa-edit"></i>'+   
                                '</a>';
                        }

                        if(jv_delete=='true'){
                            aksi +=  '<a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn_delete_order" uid="'+data+'" data-toggle="popover" title="Hapus Data" data-html="true" data-content="">'+
                                    '<i class="fas fa-trash"></i>'+
                                '</a>';
                        }
                       
                        return aksi;
                    }
                },
            ]

		});

		
	};

	return {

		//main function to initiate the module
		init: function() {
            $.fn.dataTable.ext.errMode = 'none';
			initTable();
            $('.datatable').show();
		}
	};
}();


function ResetForm(){
    document.getElementById("form-orders").reset();
    $("#order_id").val("");
    $("#nama_nasabah").val("");
    $("#tgl").val("");
    $("#invoice").val("");
    $("#pengeluaran_invoice").val("");
    $("#jenis_order").val("");
}

async function SetupForm(id="",form="order"){
    const response = await fetch('/orders/show', {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        body: JSON.stringify({
            id: id
        })
    });

    let responseJson = await response.json();

    if(responseJson.success){
        
        
        const resp = responseJson.data;

        if(form=="order"){  
            ResetForm();
            $("#order_id").val(resp.id);
            $("#nama_nasabah").val(resp.nama_nasabah);
            $("#tgl").val(tanggalIndo(resp.tanggal_order));
            $("#invoice").val(viewThousandsSeparator(resp.invoice));
            $("#pengeluaran_invoice").val(viewThousandsSeparator(resp.pengeluaran));
            $("#jenis_order_id").val(resp.jenis_order_id).trigger('change');
        }
        else{
            ResetFormTahapanProses();
            $("#order_id_tp").val(resp.id);
            $("#tahapan_proses_id").val(resp.tahapan_proses_id).trigger('change');
            $("#progres").val(resp.progres);
            $("#kendala").val(resp.kendala);
            $("#keterangan").val(resp.keterangan);
        }

        //--//
    }else{
        Swal.fire({
            title: "Error!",
            text: "Refresh dan coba kembali. Jika masih error, silahkan hubungi Administrator.",
            icon: "danger",
            buttonsStyling: false,
            confirmButtonText: "Ok",
            customClass: {
                confirmButton: "btn btn-danger"
            }
        });
    }
}


var _submitForm = function () {
    FormValidation.formValidation(
        document.getElementById('form-orders'),
        {
            fields: {
                nama_nasabah: {
                    validators: {
                        notEmpty: {
                            message: 'Nama Nasabah harus diisi'
                        }
                    }
                },
                tgl: {
                    validators: {
                        notEmpty: {
                            message: 'Nama Nasabah harus diisi'
                        }
                    }
                },
                invoice: {
                    validators: {
                        notEmpty: {
                            message: 'Invoice harus diisi'
                        }
                    }
                },
                pengeluaran_invoice: {
                    validators: {
                        notEmpty: {
                            message: 'Pengeluaran Invoice harus diisi'
                        }
                    }
                },
                jenis_order_id: {
                    validators: {
                        notEmpty: {
                            message: 'Jenis Order harus diisi'
                        }
                    }
                }
               
                
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap: new FormValidation.plugins.Bootstrap(),
                submitButton: new FormValidation.plugins.SubmitButton(),
            }
        }
    ).on('core.form.valid', function() {
        
        var formData = new FormData($("#form-orders")[0]);

        // Mengirim formulir menggunakan Ajax
        $.ajax({
            type: "POST",
            url: "/orders/submit",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                $("#ModalFormOrder").modal("hide");

                if (response.success == "true") {
                    $("#order_id").val(response.id);
                    ResetForm();
                    $("#tbl_order").DataTable().ajax.reload(null, false);
                    Swal.fire({
                        title: "Sukses!",
                        text: response.message,
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Ok",
                        customClass: {
                            confirmButton: "btn btn-primary",
                        },
                        timer: 1500,
                    });
                } else {
                    Swal.fire({
                        title: "Peringatan!",
                        text: response.message,
                        icon: "warning",
                        buttonsStyling: false,
                        confirmButtonText: "Ok",
                        customClass: {
                            confirmButton: "btn btn-warning",
                        },
                    });
                }
            },
            error: function (error) {
                console.log(error);
            },
        });
    });
}

function ResetFormTahapanProses(){
    document.getElementById("form-tahapan-proses").reset();
    $("#order_id_tp").val("");
    $("#progres").val("");
    $("#kendala").val("");
    $("#keterangan").val("");
    $("#tahapan_proses_id").val("").trigger("change");
}

var _submitTahapanProsesForm = function () {
    FormValidation.formValidation(
        document.getElementById('form-tahapan-proses'),
        {
            fields: {
                tahapan_proses_id: {
                    validators: {
                        notEmpty: {
                            message: 'Tahapan Proses harus diisi'
                        }
                    }
                },
                
                
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap: new FormValidation.plugins.Bootstrap(),
                submitButton: new FormValidation.plugins.SubmitButton(),
            }
        }
    ).on('core.form.valid', function() {
        
        var formData = new FormData($("#form-tahapan-proses")[0]);

        // Mengirim formulir menggunakan Ajax
        $.ajax({
            type: "POST",
            url: "/orders/submit/tahapanproses",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                $("#ModalFormProses").modal("hide");

                if (response.success == "true") {
                    $("#order_id_tp").val(response.id);
                    ResetFormTahapanProses();
                    $("#tbl_order").DataTable().ajax.reload(null, false);
                    Swal.fire({
                        title: "Sukses!",
                        text: response.message,
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Ok",
                        customClass: {
                            confirmButton: "btn btn-primary",
                        },
                        timer: 1500,
                    });
                } else {
                    Swal.fire({
                        title: "Peringatan!",
                        text: response.message,
                        icon: "warning",
                        buttonsStyling: false,
                        confirmButtonText: "Ok",
                        customClass: {
                            confirmButton: "btn btn-warning",
                        },
                    });
                }
            },
            error: function (error) {
                console.log(error);
            },
        });
    });
}



jQuery(document).ready(function() {

    KTDatatables.init();

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $('.show_date_picker').datepicker({
        format: "dd/mm/yyyy",
        autoclose: true

    });

    $("#invoice").on("input", function () {
        var inputValue = $(this).val().replace(/[^0-9]/g, ''); // Remove non-numeric characters
        $(this).val(viewThousandsSeparator(inputValue,0,0));
    });

    $("#pengeluaran_invoice").on("input", function () {
        var inputValue = $(this).val().replace(/[^0-9]/g, ''); // Remove non-numeric characters
        $(this).val(viewThousandsSeparator(inputValue,0,0));
    });

    $("#btn_add").on('click',function() {
        ResetForm();
    });
    
    $("#btn_submit_order").one('click',function() {
        _submitForm();
    });

    $("#btn_submit_tahapan_proses").one('click',function() {
        _submitTahapanProsesForm();
    });

    $(document).on('click', '.btn_edit_order', function() {
        var id = $(this).attr('uid');
        SetupForm(id,"order");
    });

    $(document).on('click', '.btn_update_tahapan_proses', function() {
        var id = $(this).attr('uid');
        SetupForm(id,"tahapan");
    });
    
    $(document).on('click', '.btn_delete_order', function() {
        var id = $(this).attr('uid');
        Swal.fire({
            title: "Apakah anda yakin?",
            text: "Data yang sudah dihapus tidak bisa di kembalikan lagi!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, hapus data!",
            cancelButtonText: "Batal!",
            reverseButtons: true
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    type: "DELETE",
                    url: "/orders/delete",
                    data: 'id='+id,
                    dataType: "json",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success: function(result){
                        if(result.success == "true"){
                            $('#tbl_order').DataTable().ajax.reload( null, false );
                            
                            Swal.fire({
                                title: "Sukses!",
                                text: "Data berhasil dihapus",
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                },
                                timer: 1500
                            });
                        }else{
                            Swal.fire({
                                title: "Peringatan!",
                                text: result.message,
                                icon: "warning",
                                buttonsStyling: false,
                                confirmButtonText: "Ok",
                                customClass: {
                                    confirmButton: "btn btn-warning"
                                }
                            });
                            
                        }
                    },
                    error: function(result){
                        Swal.fire({
                            title: "Error!",
                            text: result.responseJSON.message,
                            icon: "danger",
                            buttonsStyling: false,
                            confirmButtonText: "Ok",
                            customClass: {
                                confirmButton: "btn btn-danger"
                            }
                        });
                    }
                });
            }
        });
    });

    
});



"use strict";

var KTDatatables = function() {

	var initTable = function() {
        var showAct = false;
        if(jv_update=='true' || jv_delete=='true'){
            showAct = true;
        }
		var table = $('#tbl_piutang');

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
                "url": "/piutangs/list",
                "type": "GET",
                "data" : function(d){
                   
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
                { "data": "nama_karyawan" },
                
                { 
                    "data": "tanggal",
                    render: function (data, type, row, meta) {
                        return tanggalIndo(data);
                    }
                 },
                 { 
                    "data": "nominal" ,
                    "class": "text-right",
                    render: function (data, type, row, meta) {
                        return viewThousandsSeparator(data);
                    }

                },
                 { 
                    "data": "piutang_detail_sum_nominal" ,
                    "class": "text-right",
                    render: function (data, type, row, meta) {
                        let total_bayar = data ?? 0; 
                        let sisa_utang = parseInt(row.nominal) - parseInt(total_bayar);
                        if(sisa_utang==0){
                            return "<span class='badge badge-success'>Lunas</span>";
                        }else{
                            return viewThousandsSeparator(sisa_utang);
                        }
                        
                    }

                },
                {
                    "data": "id",
                    "className": "text-center",
                    "width": "120px",
                    "visible":showAct,
                    "orderable" : false,
                    render: function (data, type, row, meta) {
                        var aksi = '';

                         aksi += `
                            <a href="/piutangs/detail?uid=${data}" 
                            class="btn btn-sm btn-clean btn-icon mr-2" 
                            uid="${data}" 
                            data-toggle="tooltips" 
                            title="Detail" 
                            data-html="true" 
                            data-content="">
                                <i class="fa fa-eye"></i>
                            </a>`;

                        if(jv_update=='true'){
                            aksi += '<a href="javascript:;" data-toggle="modal" data-target="#ModalFormPiutang" class="btn btn-sm btn-clean btn-icon mr-2 btn_edit_piutang" uid="'+data+'" data-toggle="popover" title="Ubah Data" data-html="true" data-content="">'+
                                 '<i class="fa fa-edit"></i>'+   
                                '</a>';
                        }

                        if(jv_delete=='true'){
                            aksi +=  '<a href="javascript:;" class="btn btn-sm btn-clean btn-icon btn_delete_piutang" uid="'+data+'" data-toggle="popover" title="Hapus Data" data-html="true" data-content="">'+
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
    document.getElementById("form-piutang").reset();
    $("#piutang_id").val("");
    $("#nama_pegawai").val("");
    $("#jumlah_pinjaman").val("");
    $("#tgl").val("");
}

async function SetupForm(id=""){
    const response = await fetch('/piutangs/show', {
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
        ResetForm();
        
        const utg = responseJson.data;
        $("#piutang_id").val(utg.id);
        $("#nama_pegawai").val(utg.nama_karyawan);
        $("#jumlah_pinjaman").val(viewThousandsSeparator(utg.nominal));
        $("#tgl").val(tanggalIndo(utg.tanggal));

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
        document.getElementById('form-piutang'),
        {
            fields: {
                nama_pegawai: {
                    validators: {
                        notEmpty: {
                            message: 'Nama pegawai harus diisi'
                        }
                    }
                },
                jumlah_pinjaman: {
                    validators: {
                        notEmpty: {
                            message: 'Jumlah Pinjaman harus diisi'
                        }
                    }
                },
                tgl: {
                    validators: {
                        notEmpty: {
                            message: 'Tanggal harus diisi'
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
        
        var formData = new FormData($("#form-piutang")[0]);

        // Mengirim formulir menggunakan Ajax
        $.ajax({
            type: "POST",
            url: "/piutangs/submit",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                $("#ModalFormPiutang").modal("hide");

                if (response.success == "true") {
                    $("#unit_id").val(response.id);
                    ResetForm();
                    $("#tbl_piutang").DataTable().ajax.reload(null, false);
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

    $("#jumlah_pinjaman").on("input", function () {
        var inputValue = $(this).val().replace(/[^0-9]/g, ''); // Remove non-numeric characters
        $(this).val(viewThousandsSeparator(inputValue,0,0));
    });

    $("#btn_add").on('click',function() {
        ResetForm();
    });
    
    $("#btn_submit_piutang").one('click',function() {
        _submitForm();
    });

    $(document).on('click', '.btn_edit_piutang', function() {
        var id = $(this).attr('uid');
        SetupForm(id);
    });
    
    $(document).on('click', '.btn_delete_piutang', function() {
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
                    url: "/piutangs/delete",
                    data: 'id='+id,
                    dataType: "json",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success: function(result){
                        if(result.success == "true"){
                            $('#tbl_piutang').DataTable().ajax.reload( null, false );
                            
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



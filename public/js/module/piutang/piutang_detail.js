"use strict";

var KTDatatablesDetailPiutang = (function () {
    var initTableDetailPiutang = function () {
        var table = $("#tbl_detail_piutang");

        table.DataTable({
            language: {
                aria: {
                    sortAscending: ": activate to sort column ascending",
                    sortDescending: ": activate to sort column descending",
                },
                emptyTable: "Data Kosong",
                info: "Menampilkan _START_ s/d _END_ ( Total :  _TOTAL_ data)",
                infoEmpty: "Data tidak ditemukan",
                infoFiltered: "(filtered1 data _MAX_ total data)",
                lengthMenu: "Menampilkan _MENU_ data",
                search: "Cari:",
                zeroRecords: "Data tidak ditemukan",
            },
            lengthMenu: [
                [25, 50, 100, -1],
                [25, 50, 100, "Semua"],
            ],
            pageLength: 25,
            dom: "<'row' <'col-md-12'T>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>",
            tableTools: {
                sSwfPath:
                    "../../assets/global/plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf",
                aButtons: [
                    {
                        sExtends: "pdf",
                        sButtonText: "PDF",
                    },
                    {
                        sExtends: "csv",
                        sButtonText: "CSV",
                    },
                    {
                        sExtends: "xls",
                        sButtonText: "Excel",
                    },
                    {
                        sExtends: "copy",
                        sButtonText: "Copy",
                    },
                ],
            },
            processing: true,
            serverSide: true,
            ajax: {
                url: "/piutangs/detail/list", // Update with the correct URL for retur data
                type: "GET",
                data: function (d) {
                    // Add any custom data parameters here
                    d.piutang_id=$("#piutang_id").val();
                },
            },
            columns: [
                {
                    data: "id",
                    width: "50px",
                    className: "text-center",
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                },
                {
                    data: "tanggal",
                    render: function (data, type, row) {
                        // Format the date with hyphen separator and month as string in Bahasa Indonesia
                        return tanggalIndo(data);
                    },
                },
                {
                    data: "nominal",
                    render: function (data, type, row) {
                        return viewThousandsSeparator(data,0,0);
                    },
                },
                {
                    data: "keterangan",
                },
                
                {
                    data: "id",
                    className: "text-center",
                    width: "120px",
                    orderable: false,
                    render: function (data, type, row, meta) {
                        var aksi = "";

                        aksi += `
                            <a href="javascript:;" 
                            data-toggle="modal" 
                            data-target="#ModalAddDetailPiutang" 
                            class="btn btn-sm btn-clean btn-icon mr-2 btn_edit_pembayarang_utang" 
                            uid="${data}" 
                            data-toggle="popover" 
                            title="Ubah Data" 
                            data-html="true" 
                            data-content="">
                                <i class="fa fa-edit"></i>
                            </a>`;

                        aksi += `
                            <a href="javascript:;" 
                            class="btn btn-sm btn-clean btn-icon btn_delete_pembayarang_utang" 
                            uid="${data}" 
                            data-toggle="popover" 
                            title="Hapus Data" 
                            data-html="true" 
                            data-content="">
                                <i class="fas fa-trash"></i>
                            </a>`;


                        return aksi;
                    },
                },
            ],
        });
    };

    var resetForm = function () {
        document.getElementById("form-submit-bayar").reset();
        $("#detail_id").val("");
        $("#nominal_bayar").val("");
        $("#keterangan").val("")
        //$('#is_radio_payment_method1').prop('checked', false);
        
    };

    var editForm = async function (id = "") {
        const response = await fetch("/piutangs/detail/show", {
            method: "POST",
            headers: {
                Accept: "application/json",
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            body: JSON.stringify({
                id: id
            })
        });

        let responseJson = await response.json();

        if (responseJson.success) {
            resetForm();
            const returData = responseJson.data;
            // Update the form fields with the data
            $("#action_id").val('edit');
            $("#detail_id").val(returData.id);
            $("#utang_id").val(returData.piutang_id)
            $("#nominal_bayar").val(returData.nominal);
            $("#keterangan").val(returData.keterangan)
            $("#tanggal").val(returData.tanggal);
            if(returData.is_lunas==1){
                $('#is_lunas1').prop('checked', true);
            }else{
                $('#is_lunas0').prop('checked', true);
            }
        } else {
            console.log(
                "Failed to retrieve data. Message:",
                responseJson.message
            );
            Swal.fire({
                title: "Error!",
                text: "Refresh dan coba kembali. Jika masih error, silahkan hubungi Administrator.",
                icon: "danger",
                buttonsStyling: false,
                confirmButtonText: "Ok",
                customClass: {
                    confirmButton: "btn btn-danger",
                },
            });
        }
    };

    var submitForm = function () {
        FormValidation.formValidation(
            document.getElementById("form-submit-bayar"),
            {
                fields: {
                    tanggal: {
                        validators: {
                            notEmpty: {
                                message: "Tanggal harus diisi",
                            },
                        },
                    },
                    nominal_bayar: {
                        validators: {
                            notEmpty: {
                                message: "Nominal harus diisi",
                            },
                        },
                    }
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap(),
                    submitButton: new FormValidation.plugins.SubmitButton(),
                },
            }
        ).on("core.form.valid", function () {
            var formData = new FormData($("#form-submit-bayar")[0]);

            $.ajax({
                type: "POST",
                url: "/piutangs/detail/submit",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    $("#ModalAddDetailPiutang").modal("hide");

                    if (response.success == "true") {
                        $("#detail_id").val(response.id);
                        resetForm();
                        $("#tbl_detail_piutang").DataTable().ajax.reload(null, false);
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
                        }).then(function(result) {
                            location.reload();
                        })
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
    };

    var deleteData = function (id = "") {
        Swal.fire({
            title: "Apakah anda yakin?",
            text: "Data yang sudah dihapus tidak bisa di kembalikan lagi!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Ya, hapus data!",
            cancelButtonText: "Batal!",
            reverseButtons: true,
        }).then(function (result) {
            if (result.value) {
                $.ajax({
                    type: "DELETE",
                    url: "/piutangs/detail/delete",
                    dataType: "json",
                    data : {id:id},
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        ),
                    },
                    success: function (result) {
                        
                        if (result.success == "true") {
                            $("#tbl_detail_piutang").DataTable().ajax.reload(null, false);
                            Swal.fire({
                                title: "Sukses!",
                                text: "Data berhasil dihapus",
                                icon: "success",
                                buttonsStyling: false,
                                confirmButtonText: "Ok",
                                customClass: {
                                    confirmButton: "btn btn-primary",
                                },
                                timer: 1500,
                            }).then(function(result) {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: "Peringatan!",
                                text: result.message,
                                icon: "warning",
                                buttonsStyling: false,
                                confirmButtonText: "Ok",
                                customClass: {
                                    confirmButton: "btn btn-warning",
                                },
                            });
                        }
                    },
                    error: function (result) {
                        Swal.fire({
                            title: "Error!",
                            text: result.responseJSON.message,
                            icon: "danger",
                            buttonsStyling: false,
                            confirmButtonText: "Ok",
                            customClass: {
                                confirmButton: "btn btn-danger",
                            },
                        });
                    },
                });
            }
        });
    };


    // Function to initialize KTDatatablesDetailPiutang
    return {
        init: function () {
            $.fn.dataTable.ext.errMode = "none";
            initTableDetailPiutang();
            $(".datatable").show();
        },
        resetForm: resetForm,
        editForm: editForm,
        submitForm: submitForm,
        deleteData: deleteData
    };
})();

jQuery(document).ready(function () {
    KTDatatablesDetailPiutang.init();;

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $('.show_date_picker').datepicker({
        format: "dd/mm/yyyy",
        autoclose: true

    });

    $("#nominal_bayar").on("input", function () {
        var inputValue = $(this).val().replace(/[^0-9]/g, ''); // Remove non-numeric characters
        $(this).val(viewThousandsSeparator(inputValue,0,0));
    });

    $(document).one("click", "#btn_submit_pembayaran_utang", function () {
        KTDatatablesDetailPiutang.submitForm();
    });

    

    $(document).on("click", "#btnTambahdetail", function () {
        $("#action_id").val('add');
    });


    $(document).on("click", ".btn_edit_pembayarang_utang", function () {
        var id = $(this).attr("uid");
        KTDatatablesDetailPiutang.editForm(id);
    });

    $(document).on("click", ".btn_delete_pembayarang_utang", function () {
        var id = $(this).attr("uid");
        KTDatatablesDetailPiutang.deleteData(id);
    });

    $("#ModalRetur").on("hidden.bs.modal", function () {
        // Reset the form
        KTDatatablesDetailPiutang.resetForm();
    });

    $(document).on("click", "#btnTambah", function () {
        // Trigger the modal
        $("#ModalRetur").modal("show");
    });

    $("#nominal_bayar").on("input", function () {
        var inputValue = $(this).val().replace(/[^0-9]/g, ''); // Remove non-numeric characters
        var sisa = $("#sisa_utang").val();
        var act =  $("#action_id").val();
        if(parseFloat(inputValue)>parseFloat(sisa) && act=="add"){
            $(this).val("");
            Swal.fire({
                title: "Peringatan!",
                text: "Nominal Bayar tdk boleh lebih besar dari sisa utang !.",
                icon: "warning",
                buttonsStyling: false,
                confirmButtonText: "Ok",
                customClass: {
                    confirmButton: "btn btn-danger",
                },
            });
        }else{
            $(this).val(viewThousandsSeparator(inputValue,0,0));
        }
        
    });

    $('#ModalRetur').on('shown.bs.modal', function() {
        $('#transaksi_id').focus();
        if($("#retur_id").val() == '' || $("#retur_id").val() ==null) {
            $("#qty").val('1');
        }
    });

    $("#transaksi_id").keypress (function(){
        let transaksi_id = $(this).val();
        $("#master_barang_id").trigger("focus");
    });

    $("#barcode").keypress (function(){
        let barcode = $(this).val();
       if(barcode.length>5){
        getBarangbyBarcode(barcode);    
       }
       
    });
});

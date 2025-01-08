"use strict";

function getListVessel(){
    
    //$('.spin-klasifikasi-invoice').show();
    $('#show_tbl_list_vessel').html("");
    
    $.ajax({
        url        : "/vessel/status/list",
        type       : 'GET',
        contentType: false,
        cache      : false,
        processData: false,
        data       : 'status_vessel=1',
        success: function(resp){
            //$('.spin-klasifikasi-invoice').hide();
            $('#show_tbl_list_vessel').html(resp);
        },
        error: function(result){
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
    });

}

var _submitForm = function () {
    FormValidation.formValidation(
        document.getElementById('form-status-vessel'),
        {
            // fields: {
            //     status_vessel_id: {
            //         validators: {
            //             notEmpty: {
            //                 message: 'Vessel harus diisi'
            //             }
            //         }
            //     },
            // },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap: new FormValidation.plugins.Bootstrap(),
                submitButton: new FormValidation.plugins.SubmitButton(),
            }
        }
    ).on('core.form.valid', function() {

        var formData = new FormData($("#form-status-vessel")[0]);

        // Mengirim formulir menggunakan Ajax
        $.ajax({
            type: "POST",
            url: "/vessel/status/submit",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {

                if (response.success == "true") {
                   
                    getListVessel();
                    
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
    getListVessel();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    
    $("#btn_submit_status_vessel").one('click',function() {
        _submitForm();
    });

    $(document).on('click', '.btn_edit_vessel', function() {
        var id = $(this).attr('uid');
        SetupForm(id);
    });
    
    $(document).on('click', '.btn_delete_vessel', function() {
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
                    url: "/vessel/delete",
                    data: 'id='+id,
                    dataType: "json",
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    success: function(result){
                        if(result.success == "true"){
                            $('#tbl_vessel').DataTable().ajax.reload( null, false );
                            
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



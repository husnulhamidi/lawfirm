"use strict";

function getListRT(){
    
    //$('.spin-klasifikasi-invoice').show();
    $('#show_tbl_list_runningtext').html("");
    
    $.ajax({
        url        : "/system/runningtext/list",
        type       : 'GET',
        contentType: false,
        cache      : false,
        processData: false,
        data       : 'status_rt=1',
        success: function(resp){
            //$('.spin-klasifikasi-invoice').hide();
            $('#show_tbl_list_runningtext').html(resp);
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
        document.getElementById('form-position-runningtext'),
        {
            // fields: {
            //     status_rt_id: {
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

        var formData = new FormData($("#form-position-runningtext")[0]);

        // Mengirim formulir menggunakan Ajax
        $.ajax({
            type: "POST",
            url: "/system/runningtext/submit",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {

                if (response.success == "true") {
                   
                    getListRT();
                    
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
    getListRT();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    
    $("#btn_submit_status_runningtext").one('click',function() {
        _submitForm();
    });

    
});



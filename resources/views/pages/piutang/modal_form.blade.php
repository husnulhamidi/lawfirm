<!-- Modal-->
<div class="modal fade" id="ModalFormPiutang" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Piutang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form action="javascript:;" method="post" id="form-piutang" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="piutang_id" id="piutang_id" value=""/>
                  
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Nama Pegawai<span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <input name="nama_pegawai" id="nama_pegawai" type="text" class="form-control input-sm" value="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Jumlah Pinjaman <span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <input name="jumlah_pinjaman" id="jumlah_pinjaman" type="text" class="form-control input-sm text-right" value="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Tanggal <span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <div class="input-group date">
                                <input name="tgl" id="tgl" type="text" class="form-control input-sm show_date_picker" value="">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="la la-calendar-check-o"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">Tutup</button>
                    <button type="submit" id="btn_submit_piutang" class="btn btn-primary font-weight-bold">Simpan <i class="flaticon-paper-plane"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>

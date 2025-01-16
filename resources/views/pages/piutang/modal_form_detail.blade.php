<!-- Modal-->
<div class="modal fade" id="ModalAddDetailPiutang" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Pembayaran Utang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form action="javascript:;" method="post" id="form-submit-bayar">
                <div class="modal-body">
                    <input type="hidden" name="utang_id" id="utang_id" value="{{$piutang->id}}">
                    <input type="hidden" name="sisa_utang" id="sisa_utang" value="{{$sisa_utang}}">
                    <input type="hidden" name="detail_id" id="detail_id" value="">
                    <input type="hidden" name="action_id" id="action_id" value="">
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Tanggal <span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <div class="input-group date">
                                <input name="tanggal" id="tanggal" type="text" class="form-control input-sm show_date_picker" value="">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="la la-calendar-check-o"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Sisa Utang </label>
                        <div class="col-sm-8">
                            <input disabled name="sisa_utang_show" id="sisa_utang_show" type="text" class="form-control text-right" value="{{number_format($sisa_utang,0,',','.')}}">
                        </div>
                    </div> 
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Nominal Bayar <span class="text-danger">*</span></label>
                        <div class="col-sm-8">
                            <input name="nominal_bayar" id="nominal_bayar" type="text" class="form-control text-right" value="">
                        </div>
                    </div>
                    <div class="form-group row" >
                        <label class="col-sm-4 col-form-label">Lunas ?</label>
                        <div class="col-sm-8">
                            <div class="radio-inline">
                                <label class="radio radio-primary radio_lunas radio_lunasNo">
                                <input value="0" type="radio" name="is_lunas"  id="is_lunas0"  checked/>
                                    <span></span>Tidak 
                                </label>
                                <label class="radio radio-primary radio_lunas radio_lunasYes">
                                <input value="1" type="radio" name="is_lunas"  id="is_lunas1"/>
                                    <span></span>Ya, Lunas</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Keterangan</label>
                        <div class="col-sm-8">
                            <textarea name="keterangan" id="keterangan" class="form-control"></textarea>
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">Tutup</button>
                    <button type="submit" id="btn_submit_pembayaran_utang" class="btn btn-primary font-weight-bold">Simpan <i class="flaticon-paper-plane"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>

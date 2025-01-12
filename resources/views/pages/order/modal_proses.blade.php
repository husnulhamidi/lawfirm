<!-- Modal-->
<div class="modal fade" id="ModalFormProses" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Update Tahapan Proses Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form action="javascript:;" method="post" id="form-tahapan-proses" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="order_id_tp" id="order_id_tp" value=""/>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Tahapan Proses <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <select name="tahapan_proses_id" id="tahapan_proses_id" class="form-control input-sm">
                                <option value="">--- Pilih Tahapan Proses ---</option>
                                @foreach ($tahapan_proses as $tahap)
                                    <option value="{{ $tahap->id }}">{{ $tahap->name }}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Progres</label>
                        <div class="col-sm-9">
                            <input name="progres" id="progres" type="text" class="form-control input-sm" value="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Kendala </label>
                        <div class="col-sm-9">
                            <textarea name="kendala" id="kendala"  class="form-control input-sm" value=""></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Pengeluaran Invoice </label>
                        <div class="col-sm-9">
                            <textarea name="keterangan" id="keterangan"  class="form-control input-sm" value=""></textarea>
                        </div>
                    </div>
                    
                   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">Tutup</button>
                    <button type="submit" id="btn_submit_tahapan_proses" class="btn btn-primary font-weight-bold">Simpan <i class="flaticon-paper-plane"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>

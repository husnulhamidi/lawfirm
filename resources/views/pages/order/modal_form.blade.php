<!-- Modal-->
<div class="modal fade" id="ModalFormOrder" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form action="javascript:;" method="post" id="form-orders" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" name="order_id" id="order_id" value=""/>
                  
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama Nasabah <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input name="nama_nasabah" id="nama_nasabah" type="text" class="form-control input-sm" value="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Tanggal Order <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
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
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Invoice <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input name="invoice" id="invoice" type="text" class="form-control input-sm text-right" value="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Pengeluaran Invoice <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <input name="pengeluaran_invoice" id="pengeluaran_invoice" type="text" class="form-control input-sm text-right" value="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Jenis Order <span class="text-danger">*</span></label>
                        <div class="col-sm-9">
                            <select name="jenis_order_id" id="jenis_order_id" class="form-control input-sm">
                                <option value="">--- Pilih Jenis Order ---</option>
                                @foreach ($jenis_order as $ord)
                                    <option value="{{ $ord->id }}">{{ $ord->name }}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">Tutup</button>
                    <button type="submit" id="btn_submit_order" class="btn btn-primary font-weight-bold">Simpan <i class="flaticon-paper-plane"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal-->
<div class="modal fade" id="ModalFormFilter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Form Filter</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form action="javascript:;" method="post" id="form-filter" enctype="multipart/form-data">
                <div class="modal-body">
                    
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Nama Nasabah </label>
                        <div class="col-sm-9">
                            <input name="filter_nama_nasabah" id="filter_nama_nasabah" type="text" class="form-control input-sm" value="">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Tanggal Order </label>
                        <div class="col-sm-4">
                            <div class="input-group date">
                                <input name="filter_tgl_start" id="filter_tgl_start" type="text" class="form-control input-sm show_date_picker" value="">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="la la-calendar-check-o"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-1">
                            s/d
                        </div>
                        <div class="col-sm-4">
                            <div class="input-group date">
                                <input name="filter_tgl_end" id="filter_tgl_end" type="text" class="form-control input-sm show_date_picker" value="">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="la la-calendar-check-o"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Jenis Order </label>
                        <div class="col-sm-9">
                            <select name="filter_jenis_order_id" id="filter_jenis_order_id" class="form-control input-sm">
                                <option value="">--- Semua Jenis Order ---</option>
                                @foreach ($jenis_order as $ord)
                                    <option value="{{ $ord->id }}">{{ $ord->name }}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Tahapan Proses </label>
                        <div class="col-sm-9">
                            <select name="filter_tahapan_proses_id" id="filter_tahapan_proses_id" class="form-control input-sm">
                                <option value="">--- Semua Tahapan Proses ---</option>
                                @foreach ($tahapan_proses as $tahap)
                                    <option value="{{ $tahap->id }}">{{ $tahap->name }}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                   
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-danger font-weight-bold" data-dismiss="modal">Tutup</button>
                    <button type="reset" class="btn btn-default font-weight-bold">Reset</button>
                    <button type="submit" id="btn_submit_filter" class="btn btn-primary font-weight-bold">Cari <i class="flaticon-search"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>

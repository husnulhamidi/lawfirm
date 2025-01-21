<!-- Modal-->
<div class="modal fade" id="riwayat_order" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">RIWAYAT PROSES ORDER</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
                <div class="modal-body">
                    <table width="100%">
                        <tr style="border-bottom:1px dashed #ebebeb"><td width="180px">NASABAH</td><td width="5px">:</td><td><span id="nasabah_show"></span></td></tr>
                        <tr style="border-bottom:1px dashed #ebebeb"><td>TANGGAL</td><td width="5px">:</td><td><span id="tgl_order_show"></span></td></tr>
                        <tr style="border-bottom:1px dashed #ebebeb"><td>JENIS ORDER</td><td width="5px">:</td><td><span id="jenis_order_show"></span></td></tr>
                    </table>
                    <br>
                    <p><i>Riwayat</i></p>

                    <div id="list_riwayat_show"></div>
                    
                   
                </div>
                <div class="modal-footer">
                    <form method="get" target="_blank" action="{{ route('orders.print-riwayat') }}">
                        <input type="hidden" name="print_order_id" id="print_order_id" class="form-control input-sm"  value="">
                        <button class="btn btn-success btn-sm mr-1 font-weight-bolder">
                            <span class="flaticon-file-2"></span> 
                            Print
                        </button>
                    </form>
                    <button type="button" class="btn btn-light-danger btn-sm  font-weight-bold" data-dismiss="modal">Tutup</button>
                </div>
           
        </div>
    </div>
</div>
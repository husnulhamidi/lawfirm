{{-- Extends layout --}}
@extends('layout.default')

@section('content')
    <div class="panel-grid-retur">
        <div class="card card-custom">
            <div class="card-header flex-wrap border-1 pt-6 pb-0">
                <div class="card-title">
                    <h3 class="card-label">List Pembayaran Utang</h3>
                </div>
                <!-- <div class="card-toolbar">
                    <a class="btn btn-primary btn-sm mr-2 font-weight-bolder" id="btnTambah">
                        <span class="flaticon-plus"></span> Tambah
                    </a>
                </div> -->
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <form>
                            <input type="hidden" name="piutang_id" id="piutang_id" value="{{$piutang->id}}">
                        </form>
                        <table class="table">
                            <tr>
                                <td width="150px">Nama Pegawai</td><td width="5px">:</td>
                                <td align="left">{{$piutang->nama_karyawan}}</td>
                            </tr>
                            <tr>
                                <td width="150px">Tanggal</td><td width="5px">:</td>
                                <td align="left"><?php echo date("d-m-Y",strtotime($piutang->tanggal));?></td>
                            <tr>
                                <td>Jumlah Pinjaman</td><td width="5px">:</td>
                                <td>Rp. {{number_format($piutang->nominal,0,',','.')}}</td>
                            </tr>
                            <tr>
                                <td>Terbayar</td><td width="5px">:</td>
                                <td>Rp. {{number_format($terbayar,0,',','.')}}</td>
                            </tr>
                            <tr>
                                <td>Sisa Utang</td><td width="5px">:</td>
                                <td>
                                    Rp. <span id="text_sisa_utang">{{number_format($sisa_utang,0,',','.')}}</span>
                                </td>
                            </tr>
                            
                        </table>
                    </div>
                </div>

                <div class="separator separator-dashed separator-border-2"></div>
                <br>
                
                <div class="card-toolbar text-right">
                    <a class="btn btn-primary btn-sm mr-2 font-weight-bolder" data-toggle="modal" data-target="#ModalAddDetailPiutang" id="btnTambahdetail">
                        <span class="flaticon-plus"></span> Tambah
                    </a>
                </div> 
                <table class="table table-bordered" id="tbl_detail_piutang">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Tanggal</th>
                            <th>Nominal Bayar</th>
                            <th>Keterangan</th>
                            <th width="80px">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    @include('pages.piutang.modal_form_detail')
@endsection

{{-- Styles Section --}}
@section('styles')
    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection

{{-- Scripts Section --}}
@section('scripts')
    <script>
        const url_json = "";
        const role_id = '{{ auth()->user()->role_id }}';
    </script>

    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>
    <script src="{{ asset('js/pages/crud/forms/widgets/input-mask.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/module/piutang/piutang_detail.js?random=' . date('ymdHis')) }}" type="text/javascript"></script>
</script>
@endsection

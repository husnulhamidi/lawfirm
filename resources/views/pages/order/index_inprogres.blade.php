{{-- Extends layout --}}
@extends('layout.default')

@section('content')
    <div class="panel-grid-supplier">
        <div class="card card-custom">
            <div class="card-header flex-wrap border-1 pt-6 pb-0">
                <div class="card-title">
                    <h3 class="card-label">{{$title}}</h3>
                </div>
                <div class="card-toolbar">
                    <a class="btn btn-light-primary btn-sm mr-2 font-weight-bolder" id="btn_filter" data-toggle="modal" data-target="#ModalFormFilter">
                        <span class="fa fa-filter"></span> Filter
                    </a>
                    
                    <form method="get" action="{{ route('orders.export') }}">
                        <input type="hidden" name="nama_nasabah_exp" id="nama_nasabah_exp" class="form-control input-sm"  value="">
                        <input type="hidden" name="tgl_start_exp" id="tgl_start_exp" class="form-control input-sm" placeholder="sart_tgl_invoice"  value="">
                        <input type="hidden" name="tgl_end_exp" id="tgl_end_exp" class="form-control input-sm" placeholder="sart_tgl_invoice"  value="">
                        <input type="hidden" name="jenis_order_id_exp" id="jenis_order_id_exp" class="form-control input-sm"  value="">
                        <input type="hidden" name="tahapan_proses_exp" id="tahapan_proses_exp" class="form-control input-sm"  value="">
                       
                        <!-- <button class="btn btn-success btn-sm mr-2 font-weight-bolder btn-export-order">
                            <span class="flaticon-file-2"></span> 
                            Export Order
                        </button> -->
                    </form>
                    @if ($accessMenu['add']=='true')
                    <a class="btn btn-primary btn-sm mr-2 font-weight-bolder" id="btn_add" data-toggle="modal" data-target="#ModalFormOrder">
                        <span class="flaticon-plus"></span> Tambah
                    </a>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <!--begin: Datatable-->
                <table class="table table-bordered" id="tbl_order">
                    <thead>
                        <tr>
                            <th width="20px">No.</th>
                            <th>Nasabah</th>
                            <th>Tanggal Order</th>
                            <th>Invoice</th>
                            <th>Pengeluaran Invoice</th>
                            <th>Jenis Order</th>
                            <th>Tahap Pekerjaan</th>
                            <th>Progres</th>
                            <th>Kendala</th>
                            <th>Keterangan</th>
                            <th width="80px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Loop through orders and display data here --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('pages/order/modal_form')
    @include('pages/order/modal_proses')
    @include('pages/order/modal_riwayat')
    @include('pages/order/modal_filter')
@endsection

{{-- Styles Section --}}
@section('styles')
    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
@endsection

{{-- Scripts Section --}}
@section('scripts')
    <script>
        const url_json = "";
        const role_id = '{{auth()->user()->role_id}}';
        const submenu = '{{$submenu}}';
    </script>

    <!--begin::Page Scripts(used by this page)-->
    <script src="{{ asset('js/pages/widgets.js') }}"></script>
    <script src="{{ asset('js/pages/crud/forms/widgets/bootstrap-datepicker.js') }}"></script>
    <!--end::Page Scripts-->
        
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/module/order/order.js?random='.date('ymdHis')) }}" type="text/javascript"></script>
@endsection
{{-- Content --}}

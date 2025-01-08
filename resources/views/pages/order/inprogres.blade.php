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
                            <th>No.</th>
                            <th>Nasabah</th>
                            <th>Tanggal Order</th>
                            <th>Invoice</th>
                            <th>Pengeluaran Invoice</th>
                            <th>Jenis Order</th>
                            <th>Tahap Pekerjaan</th>
                            <th>Progres</th>
                            <th>Kendala</th>
                            <th>Keterangan</th>
                            <th>Selesai</th>
                            <th width="80px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Loop through biomasa and display data here --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @include('pages/order/modal_form')
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
    </script>
        
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/module/order/order.js?random='.date('ymdHis')) }}" type="text/javascript"></script>
@endsection
{{-- Content --}}

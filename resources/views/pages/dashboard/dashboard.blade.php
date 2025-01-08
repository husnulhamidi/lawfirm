{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
    {{-- Dashboard 1 --}}

    <div class="panel-grid-supplier">
    <div class="mt-20 text-center">
							
				<h1>Selamat Datang , {{Auth::user()->name}}	</h1>	
           
        </div>
       


    </div>
@endsection

{{-- Scripts Section --}}
@section('scripts')
    <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/pages/widgets.js') }}" type="text/javascript"></script>
    
    <script>
        const start_date = "{{ $startDate }}";
        const end_date = "{{ $endDate }}";
    </script>
@endsection

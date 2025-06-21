@extends('layouts.app')

@section('title')
    Attendance Scanner
@endsection

@section('content')
    <!-- Container-fluid starts-->
    <div class="container-fluid" style="padding-top:25px">

        @livewire('attendance-scanner')

    </div>
@endsection

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('qrcode/css/qr_scan.css') }}">
    <style>
        #student-table th,
        #student-table td {
            padding: 5px 0px;
        }

        @media (max-width: 575.98px) {
            .card-header {
                flex-direction: column;
                justify-content: flex-start !important;
                padding: 15px;
                align-items: flex-start !important;
            }

            .event-selection{
                width: 100%;
            }
        }
    </style>
@endpush


@section('scripts')
    <script src="{{ asset('qrcode/js/CodeScan.js') }}"></script>
    <script src="{{ asset('qrcode/js/main.js') }}"></script>

    <script>
        $('.single-select').select2();

        var html5QrcodeScanner = new Html5QrcodeScanner(
            "qr-reader", {
                fps: 10,
                qrbox: 250
            });
        html5QrcodeScanner.render(onScanSuccess);


        function closeModal() {
            $('#scan-section').hide();
            $('#text-section').show();
            $('#add-qr-modal').modal('hide');
        }
    </script>
@endsection

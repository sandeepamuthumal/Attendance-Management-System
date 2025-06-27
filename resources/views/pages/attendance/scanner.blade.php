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

            .event-selection {
                width: 100%;
            }
        }
    </style>
    {{-- Custom Styles --}}
    <style>
        .attendance-scanner-container {
            min-height: 70vh;
        }

        .qr-scanner-container {
            background: #f8f9fa;
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .qr-scanner-container:hover {
            border-color: #134D80;
            background: #f0f8ff;
        }

        .scan-section {
            transition: all 0.3s ease;
        }

        .student-details-table {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
        }

        .student-details-table table td:first-child {
            width: 40%;
            color: #6c757d;
        }

        .student-details-table table td:last-child {
            font-weight: 500;
            color: #495057;
        }

        .badge {
            font-size: 0.875rem !important;
            font-weight: 500;
        }

        .progress {
            background-color: #e9ecef;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #134D80;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .btn-primary {
            background-color: #134D80;
            border-color: #134D80;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border: 1px solid rgba(0, 0, 0, 0.125);
        }

        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
        }

        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
        }

        @media (max-width: 768px) {

            .col-lg-8,
            .col-lg-4 {
                margin-bottom: 1rem;
            }

            .modal-dialog {
                margin: 1rem;
            }

            .qr-scanner-container {
                padding: 15px;
            }
        }

        /* Animation classes */
        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        .animate__pulse {
            animation: pulse 1s ease-in-out;
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

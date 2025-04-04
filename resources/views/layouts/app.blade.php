<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Favicons -->
    <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
<link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
<link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
<link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
<link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">


    <!-- bootstrap style cdn -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    {{-- toaster --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/style.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/css/toggle.css')}}" rel="stylesheet">
    <!-- Material Design Icons (MDI) CDN -->
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.15.10/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.15.10/sweetalert2.css" />

    <!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <div id="loading-overlay">Loading...</div>


        <!-- Page Content -->
        <main id="main" class="main">
            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset
            {{ $slot }}
        </main>
    </div>

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>Integra Micro Systems Private Limited</span></strong>. All Rights Reserved
        </div>
    </footer><!-- End Footer -->

    @can('create-attendance')
        <!-- On/Off-Duty camera Popup -->
        <div id="camera-popup" class="popup hidden">
            <div class="popup-content">
                <button class="close-btn" id="popup-close">&times;</button>
                <h3 id="popupTitle">Go On Duty</h3>
                <form id="on-duty-form">
                    <div id="photoCaptureContent">
                        <div id="permission-message">
                        </div>
                        <video id="video" width="100%" height="auto" autoplay></video>
                        <canvas id="canvas" class="d-none"></canvas>
                        <img id="capturedPhoto" class="img-thumbnail d-none" src="{{ asset('assets/img/placeholder.jpg') }}" alt="Captured photo">
                    </div>

                    {{-- <div class="d-none mt-3" id="aditionalInput">
                        <div class="row">
                            <div class="col-md-6 mb-1">
                                <input type="text" class="form-control small-input" id="transaction" name="transaction"
                                    placeholder="Total Transaction" required>
                                <div class="invalid-feedback">Please enter total transaction.</div>
                            </div>
                            <div class="col-md-6 mb-1">
                                <input type="text" class="form-control small-input" id="onboarding" name="onboarding"
                                    placeholder="Onboarding Count" required>
                                <div class="invalid-feedback">Please enter onboarding count.</div>
                            </div>
                            <div class="col-md-12 mb-1">
                                <input type="text" class="form-control small-input" id="remarks" name="remarks"
                                    placeholder="Remarks" required>
                                <div class="invalid-feedback">Please enter remarks.</div>
                            </div>
                        </div>
                    </div> --}}

                    <div class="popup-footer mt-3 d-flex justify-content-center">
                        <button type="button" class="iconButtons btn btn-primary d-none" id="captureBtn"
                            title="Capture">Capture</button>
                        <button type="button" class="btn btn-danger d-none mx-4" id="retakeBtn"
                            title="Retake">Retake</button>
                        <button type="button" class="btn btn-success d-none" id="confirmBtn" title="Confirm">On
                            Duty</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Camera Popup End -->
    @endcan

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

{{-- Define routes for js files --}}
<script>
    var getTime = "{{ route('get-time') }}";
    var getDutyStatus = "{{ route('duty-status') }}";
    var postDutyStatus = "{{ route('post-duty-status') }}";
    var resolveDuty = "{{ route('resolve-duty') }}";
    var startDutyDataSave = "{{ route('startDutyDataSave') }}";
    var checkDataEntryStatus = "{{ route('checkDataEntryStatus') }}";

    var dashboardData = "{{ route('dashboard-data') }}";
    var getTotalWorkingHours = "{{ route('getTotalWorkingHours') }}";
    var getAttendanceCount = "{{ route('getAttendanceCount') }}";
    var getTotalLeaves = "{{ route('getTotalLeaves') }}";
    var getLateArrivals = "{{ route('getLateArrivals') }}";
    var getEarlyDepartures = "{{ route('getEarlyDepartures') }}";
    var getOvertime = "{{ route('getOvertime') }}";

    var getAdminDashboardData = "{{ route('getAdminDashboardData') }}";
    var getAdminAttendanceCount = "{{ route('getAdminAttendanceCount') }}";
    var getAdminTotalLeaves = "{{ route('getAdminTotalLeaves') }}";
    var getAdminTotalAbsent = "{{ route('getAdminTotalAbsent') }}";
    var getAdminLateArrivals = "{{ route('getAdminLateArrivals') }}";
    var getAdminEarlyDepartures = "{{ route('getAdminEarlyDepartures') }}";
    var getAdminOntime = "{{ route('getAdminOntime') }}";

    var getCalendarData = "{{ route('getCalendarData') }}";
    var getDuties = "{{ route('getDuties') }}";
    var getAvailableOptions = "{{ route('getAvailableOptions') }}";

    var transactionToday = "";
    var transactions = "{{ route('transactions.index') }}";


    var baseUrl = "{{ asset('public') }}";
    
</script>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js')}}"></script>
    <script src="{{ asset('assets/vendor/chart.js/chart.umd.js')}}"></script>
    <script src="{{ asset('assets/vendor/echarts/echarts.min.js')}}"></script>
    <script src="{{ asset('assets/vendor/quill/quill.js')}}"></script>
    <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js')}}"></script>
    <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js')}}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js')}}"></script>
    {{-- Toaster --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- Bootstrap Js CDN -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script> -->
    <!-- Template Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    @can('create-attendance')
        <script src="{{ asset('assets/js/toggle.js') }}"></script>
        {{-- <script src="/assets/js/photo.js"></script> --}}
    @endcan
</body>

</html>

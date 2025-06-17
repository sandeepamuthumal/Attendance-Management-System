<!-- jquery-->
<script src="{{ asset('assets/js/vendors/jquery/jquery.min.js') }}"></script>
<!-- bootstrap js-->
<script src="{{ asset('assets/js/vendors/bootstrap/dist/js/bootstrap.bundle.min.js') }}" defer=""></script>
<script src="{{ asset('assets/js/vendors/bootstrap/dist/js/popper.min.js') }}" defer=""></script>
<!--fontawesome-->
<script src="{{ asset('assets/js/vendors/font-awesome/fontawesome-min.js') }}"></script>
<!-- feather-->
<script src="{{ asset('assets/js/vendors/feather-icon/feather.min.js') }}"></script>
<script src="{{ asset('assets/js/vendors/feather-icon/custom-script.js') }}"></script>
<!-- sidebar -->
<script src="{{ asset('assets/js/sidebar.js') }}"></script>
<!-- height_equal-->
<script src="{{ asset('assets/js/height-equal.js') }}"></script>
<!-- config-->
<script src="{{ asset('assets/js/config.js') }}"></script>
<!-- apex-->
<script src="{{ asset('assets/js/chart/apex-chart/apex-chart.js') }}"></script>
<script src="{{ asset('assets/js/chart/apex-chart/stock-prices.js') }}"></script>
<!-- scrollbar-->
<script src="{{ asset('assets/js/scrollbar/simplebar.js') }}"></script>
<script src="{{ asset('assets/js/scrollbar/custom.js') }}"></script>
<!-- slick-->
<script src="{{ asset('assets/js/slick/slick.min.js') }}"></script>
<script src="{{ asset('assets/js/slick/slick.js') }}"></script>
<!-- data_table-->
<script src="{{ asset('assets/js/js-datatables/datatables/jquery.dataTables.min.js') }}"></script>
<!-- page_datatable-->
<script src="{{ asset('assets/js/js-datatables/datatables/datatable.custom.js') }}"></script>
<!-- page_datatable-->
<script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>


<!-- theme_customizer-->
<script src="{{ asset('assets/js/theme-customizer/customizer.js') }}"></script>
<!-- tilt-->
<script src="{{ asset('assets/js/animation/tilt/tilt.jquery.js') }}"></script>
<!-- page_tilt-->
<script src="{{ asset('assets/js/animation/tilt/tilt-custom.js') }}"></script>

<!-- Sweetalert js-->
<script src="{{ asset('assets/js/sweetalert/sweetalert2.min.js') }}"></script>
<script src="{{ asset('assets/js/sweetalert/sweetalert-custom.js') }}"></script>

<!-- dashboard_1-->
<script src="{{ asset('assets/js/dashboard/dashboard_1.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
    integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
    integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<!-- custom script -->
<script src="{{ asset('assets/js/script.js') }}"></script>

<script type="text/javascript">
    const preloader = document.querySelector('#preloader');
    if (preloader) {
        preloader.classList.remove('hidden');
        window.addEventListener('load', () => {
            preloader.classList.add('hidden');
        });
    }

    function showPreloader() {
        const preloader = document.querySelector('#preloader');
        if (preloader) {
            preloader.classList.remove('hidden'); // Show preloader
        }
    }

    function hidePreloader() {
        const preloader = document.querySelector('#preloader');
        if (preloader) {
            preloader.classList.add('hidden'); // Hide preloader with transition
        }
    }

    @if (Session::has('message'))
        toastr.options = {
            "closeButton": true,
            "progressBar": true
        }
        toastr.success("{{ session('message') }}");
    @endif

    @if (Session::has('error'))
        toastr.options = {
            "closeButton": true,
            "progressBar": true
        }
        toastr.error("{{ session('error') }}");
    @endif
</script>

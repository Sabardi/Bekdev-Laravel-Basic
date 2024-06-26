<script src="{{ asset('assets') }}/vendor/libs/jquery/jquery.js"></script>
<script src="{{ asset('assets') }}/vendor/libs/popper/popper.js"></script>
<script src="{{ asset('assets') }}/vendor/js/bootstrap.js"></script>
<script src="{{ asset('assets') }}/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="{{ asset('assets') }}/vendor/js/menu.js"></script>

<!-- endbuild -->

<!-- Vendors JS -->
<script src="{{ asset('assets') }}/vendor/libs/apex-charts/apexcharts.js"></script>

<!-- Main JS -->
<script src="{{ asset('assets') }}/js/main.js"></script>

<!-- Page JS -->
<script src="{{ asset('assets') }}/js/dashboards-analytics.js"></script>

<!-- Place this tag in your head or just before your close body tag. -->
<script async defer src="https://buttons.github.io/buttons.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="{{ asset('vendor/waitMe.js') }}"></script>
<script>
    //message with sweetalert
    @if (session('success'))
        Swal.fire({
            icon: "success",
            title: "BERHASIL",
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 2000
        });
    @elseif (session('error'))
        Swal.fire({
            icon: "error",
            title: "GAGAL!",
            text: "{{ session('error') }}",
            showConfirmButton: false,
            timer: 2000
        });
    @endif

    function LoadingShow() {
        $('#loading').waitMe({
            effect: 'bounce',
            text: 'Loading...',
            bg: "rgba(255, 255, 255, 0.7)",
            color: "#000",
            maxSize: '',
            waitTime: -1,
            textPos: 'vertical',
            fontSize: '',
            source: '',
            onClose: function() {}
        });
    }

    function LoadingHide() {
        $('#loading').waitMe('hide');
    }
</script>

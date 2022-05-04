@if ($errors->any())

    <script type="text/javascript">
        Swal.fire({
            title: 'An error occured, try again',
            icon: 'error',
            html: `
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    `,

            showCancelButton: false,
            focusConfirm: false,
            confirmButtonText: '<i class="fas fa-times"></i> Close!',
            confirmButtonAriaLabel: 'Close',

        });
    </script>
@endif

@isset($Status)
    <script type="text/javascript">
        $(function() {

            Swal.fire('Information', '{{ $Status }}', 'success');

        });
    </script>
@endisset
@if (session('status'))
    <script type="text/javascript">
        $(function() {

            Swal.fire('Information', '{{ session('status') }}',
                'success');

        });
    </script>
@endif

@if (session('taxadded'))
    <script type="text/javascript">
        $(function() {
            var myModal = new bootstrap.Modal(document.getElementById(
                "MgtTaxes"), {});
            document.onreadystatechange = function() {
                myModal.show();
            };

            Swal.fire('Information', '{{ session('taxadded') }}',
                'success');

        });
    </script>
@endif


@if (session('taxerror'))
    <script type="text/javascript">
        $(function() {
            var myModal = new bootstrap.Modal(document.getElementById(
                "MgtTaxes"), {});
            document.onreadystatechange = function() {
                myModal.show();
            };

            Swal.fire('Information', '{{ session('taxerror') }}',
                'error');

        });
    </script>
@endif

@if (session('error_a'))
    <script type="text/javascript">
        $(function() {

            Swal.fire('Information', '{{ session('error_a') }}', 'error');

        });
    </script>
@endif


@isset($SelectKyc)
    <script>
        Swal.fire('Select Investment',
            'Select the investment whose KYC is to be reviewed', 'success');
    </script>
@endisset



@if (isset($rem))
    <script>
        $(function() {

            if ($('.x_analyzed').length > 0) {
                $('.x_ExtendedValidity').remove();
            }
            if ($('.x_analyzed').length > 0) {

                $('.x_analyzed').remove();

            }
            @foreach ($rem as $val)
                $(".x_{{ $val }}").remove();
            @endforeach

            BootEditor();
        });
    </script>
@else
    <script>
        $(function() {

            BootEditor();

        });
    </script>

@endif



@if (isset($rem2))
    <script>
        $(function() {

            @foreach ($rem2 as $val)
                $(".x_{{ $val }}").remove();
            @endforeach

            BootEditor();
        });
    </script>
@else
    <script>
        $(function() {

            BootEditor();

        });
    </script>

@endif

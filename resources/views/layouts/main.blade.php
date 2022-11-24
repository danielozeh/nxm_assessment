<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>{{config('app.name')}} | Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta content="Buying gift-cards or turning gift-cards to Cash has never been this easy and safe too, with Patricia you come first, trade conveniently from any device, anytime, anywhere, 24/7" name="description"/>
    <meta content="Patricia" name="author"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>

    <link rel="shortcut icon" href="{{ asset('/assets/images/naxum.png') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!--Morris Chart CSS -->
    <link rel="stylesheet" href="{{ asset('/assets/plugins/morris/morris.css') }}">

    <!-- App css -->
    <link href="{{ asset('/admin/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css"/>

    <link href="{{ asset('/admin/css/icons.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/admin/css/style.css') }}" rel="stylesheet" type="text/css"/>

    <link href="{{ asset('/assets/plugins/bootstrap-table/css/bootstrap-table.min.css') }}" Type="text/css"
          rel="stylesheet">

    <link href="{{ asset('/assets/plugins/sweet-alert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css">

    <link href="{{ asset('/admin/css/custom-styles.css') }}" rel="stylesheet" type="text/css">

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    @yield("style")

    <script type="text/javascript">
    const baseUrl = '<?=url('');?>';
</script>
    <script src="{{ asset('/admin/js/modernizr.min.js') }}"></script>
</head>


<body>
<!-- Begin page -->
<div id="wrapper">
    @include('layouts.header')
    @yield("content")
    @include('layouts.footer')
</div>
<script>
    var resizefunc = [];
</script>

<!-- jQuery  -->
<script src="{{ asset('/admin/js/jquery.min.js') }}"></script>
<script src="{{ asset('/admin/js/popper.min.js') }}"></script><!-- Popper for Bootstrap -->
<script src="{{ asset('/admin/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('/admin/js/detect.js') }}"></script>
<script src="{{ asset('/admin/js/fastclick.js') }}"></script>
<script src="{{ asset('/admin/js/jquery.slimscroll.js') }}"></script>
<script src="{{ asset('/admin/js/jquery.blockUI.js') }}"></script>
<script src="{{ asset('/admin/js/waves.js') }}"></script>
<script src="{{ asset('/admin/js/wow.min.js') }}"></script>
<script src="{{ asset('/admin/js/jquery.nicescroll.js') }}"></script>
<script src="{{ asset('/admin/js/jquery.scrollTo.min.js') }}"></script>

<script src="{{ asset('/assets/plugins/peity/jquery.peity.min.js') }}"></script>

<!-- jQuery  -->
<script src="{{ asset('/assets/plugins/waypoints/lib/jquery.waypoints.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/counterup/jquery.counterup.min.js') }}"></script>

<script src="{{ asset('/assets/plugins/morris/morris.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/raphael/raphael-min.js') }}"></script>

<script src="{{ asset('/assets/plugins/jquery-knob/jquery.knob.js') }}"></script>

<script src="{{ asset('/admin/pages/jquery.dashboard.js') }}"></script>
<script src="{{ asset('assets/plugins/sweet-alert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('/admin/pages/jquery.sweet-alert2.init.js') }}"></script>

<script src="{{ asset('/admin/js/jquery.core.js') }}"></script>
<script src="{{ asset('/admin/js/jquery.app.js') }}"></script>

<script type="{{ asset('/admin/js/text/javascript') }}">
    jQuery(document).ready(function ($) {
        $('.counter').counterUp({
            delay: 100,
            time: 1200
        });

        $(".knob").knob();
    });
</script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="{{ asset('/admin/js/custom-script.js') }}"></script>
@yield("script")
</body>
</html>

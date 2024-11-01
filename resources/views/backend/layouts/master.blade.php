
<!doctype html>
<html lang="en">

<head>
    @include('backend.layouts.head')
</head>
<body class="theme-blue">

<!-- Page Loader -->
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="m-t-30"><img src="{{asset('backend/assets/images/loader.gif')}}" width="48" height="48" alt="Lucid"></div>
        <p>Please wait...</p>
    </div>
</div>
<!-- Overlay For Sidebars -->

<div id="wrapper">

    <nav class="navbar navbar-fixed-top">
        @include('backend.layouts.nav')
    </nav>

    <div id="left-sidebar" class="sidebar">
        @include('backend.layouts.sidebar')
    </div>

    @yield('content')


    
</div>
@include('backend.layouts.footer')
</body>
</html>

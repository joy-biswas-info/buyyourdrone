<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') . ' - Admin Dashboard' }}</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('admin/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/plugins/dropzone/min/dropzone.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('admin/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/custom.css') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="{{ asset('admin/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/plugins/dropzone/min/dropzone.min.js') }}"></script>

</head>
</head>

<body class="hold-transition sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Right navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
            </ul>
            <div class="navbar-nav pl-2">
            </div>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link p-0 pr-3" data-toggle="dropdown" href="#">
                        <img src="{{ asset('admin/img/avatar5.png') }}" class='img-circle elevation-2' width="40"
                            height="40" alt="">
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-3">
                        <h4 class="h4 mb-0"><strong>{{ Auth::user()->name }}</strong></h4>
                        <div class="mb-3">{{ Auth::user()->email }}</div>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-user-cog mr-2"></i> Settings
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-lock mr-2"></i> Change Password
                        </a>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a :href="route('logout')"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();"
                                class="dropdown-item text-danger">
                                <i class="fas fa-sign-out-alt mr-2"></i>

                                {{ __('Log Out') }}
                            </a>
                        </form>

                    </div>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->
        <!-- Main Sidebar Container -->
        @include('admin.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @if (isset($header))
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>{{ $header }}</h1>
                            </div>
                        </div>
                    </div>
                    <!-- /.container-fluid -->
                </section>
            @endif
            <div class="container">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @elseif (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
            </div>
            <!-- Main content -->
            {{ $slot }}
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">

            <strong>Copyright &copy; 2014-2025 BuyYourDrones All rights reserved.
        </footer>

    </div>
    <!-- Include jQuery first -->

    <!-- Then include Bootstrap 4 -->
    <script src="{{ asset('admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Followed by other dependencies -->


    <!-- Finally, include your custom scripts -->
    <script src="{{ asset('admin/js/adminlte.min.js') }}"></script>

</body>
<script>
    setTimeout(function() {
        $('.alert.alert-success').fadeOut('slow');
    }, 7000);
    setTimeout(function() {
        $('.alert.alert-danger').fadeOut('slow');
    }, 7000);
</script>

</html>

<!doctype html>

<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Dashboard - Tabler - Premium and Open Source dashboard template with responsive and high quality UI.</title>
    <!-- CSS files -->
    <link href="/css/tabler.min.css?1684106062" rel="stylesheet" />
    <link href="/css/tabler-flags.min.css?1684106062" rel="stylesheet" />
    <link href="/css/tabler-payments.min.css?1684106062" rel="stylesheet" />
    <link href="/css/tabler-vendors.min.css?1684106062" rel="stylesheet" />
    <link href="/css/demo.min.css?1684106062" rel="stylesheet" />
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }
    </style>
</head>

<body>
    <script src="/js/demo-theme.min.js?1684106062"></script>
    <div class="page">

        <!-- Sidebar -->
        @include('partials.navbar')

        <!-- Header -->
        @include('partials.header')

        <div class="page-wrapper">

            <!-- Page header -->
            @yield('header')

            <!-- Page body -->
            <div class="page-body">
                <div class="container-xl">
                    <div class="row row-deck row-cards">

                        <!-- Page Content -->
                        {{ $slot }}

                    </div>
                </div>
            </div>

            <!-- Page Footer -->
            @include('partials.footer')

        </div>
    </div>

    <!-- Page Modal -->
    @yield('modal')

    <!-- Libs JS -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.6/dist/umd/popper.min.js"
        integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/js/bootstrap.min.js"
        integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="/libs/apexcharts/dist/apexcharts.min.js?1684106062" defer></script>
    <script src="/libs/jsvectormap/dist/js/jsvectormap.min.js?1684106062" defer></script>
    <script src="/libs/jsvectormap/dist/maps/world.js?1684106062" defer></script>
    <script src="/libs/jsvectormap/dist/maps/world-merc.js?1684106062" defer></script>
    <!-- Tabler Core -->
    <script src="/js/tabler.min.js?1684106062" defer></script>
    <script src="/js/demo.min.js?1684106062" defer></script>
    @yield('js')
</body>

</html>

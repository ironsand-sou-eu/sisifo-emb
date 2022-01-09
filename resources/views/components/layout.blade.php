<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <x-html-header />
    <body id="page-top">
        <div id="wrapper">
            <x-sidebar />

            <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">
                    <!-- Topbar -->
                    <x-topbar />

                    <!-- Begin Page Content -->
                    <div class="container-fluid">
                        <x-flash-message />
                        {{ $slot }}
                    </div>
                    <!-- End of Page Content -->
                </div>

                <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span><a href="mailto:{{ __('pages.adminEmail') }}">{{ __("pages.footerText") }}</a></span>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        
        <a class="scroll-to-top rounded" href="#page-top" style="display: none;">
            <i class="fas fa-angle-up"></i>
        </a>
        <!-- Scripts-->
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/sb-admin-2.min.js"></script>
        <script src="https://kit.fontawesome.com/b915ce401c.js" crossorigin="anonymous"></script>
    </body>
</html>
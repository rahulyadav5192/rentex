@include('theme.head')

<body class="tw-flex tw-min-h-[100vh] tw-flex-col tw-bg-[#fcfcfc] tw-text-black dark:tw-bg-black dark:tw-text-white">
    <!-- Main Header Nav -->
    @include('theme.header')

    <!-- Main Content -->
    @yield('content')

    <!-- Footer -->
    @include('theme.footer')

    <!-- Modal for custom content -->
    <div class="modal fade" id="customModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="body">
                </div>
            </div>
        </div>
    </div>

    @include('theme.footer-scripts')
</body>

</html>

<style>
    .footer-link {
        width: fit-content;
        color: #282828;
        transition: color 0.3s;
        text-decoration: none;
    }
    
    .dark .footer-link {
        color: #cfcfcf;
    }
    
    .footer-link:hover {
        color: #000;
    }
    
    .dark .footer-link:hover {
        color: #fff;
    }
    
    body.modal-open {
        overflow: hidden;
    }
</style>

<script src="{{ asset('js/jquery.js') }}"></script>
<script src="{{ asset('assets/web/js/jquery-migrate-3.5.2.min.js') }}"></script>
<script src="{{ asset('assets/web/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/web/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/web/js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('assets/web/js/jquery.mmenu.all.js') }}"></script>
<script src="{{ asset('assets/web/js/ace-responsive-menu.js') }}"></script>
<script src="{{ asset('assets/web/js/jquery-scrolltofixed-min.js') }}"></script>
<script src="{{ asset('assets/web/js/wow.min.js') }}"></script>
<script src="{{ asset('assets/web/js/isotop.js') }}"></script>
<script src="{{ asset('assets/web/js/owl.js') }}"></script>
<script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/notifier.js') }}"></script>
<script src="{{ asset('assets/web/js/script.js') }}"></script>

@stack('script-page')

<script>
    var successImg='{{ asset("assets/images/notification/ok-48.png") }}';
    var errorImg='{{ asset("assets/images/notification/high_priority-48.png") }}';
</script>
<script src="{{ asset('js/custom.js') }}"></script>

<!-- New Theme JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.0/gsap.min.js" integrity="sha512-B1lby8cGcAUU3GR+Fd809/ZxgHbfwJMp0jLTVfHiArTuUt++VqSlJpaJvhNtRf3NERaxDNmmxkdx2o+aHd4bvw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.0/ScrollTrigger.min.js" integrity="sha512-AY2+JxnBETJ0wcXnLPCcZJIJx0eimyhz3OJ55k2Jx4RtYC+XdIi2VtJQ+tP3BaTst4otlGG1TtPJ9fKrAUnRdQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/typed.js/2.0.10/typed.min.js" integrity="sha512-hIlMpy2enepx9maXZF1gn0hsvPLerXoLHdb095CmRY5HG3bZfN7XPBZ14g+TUDH1aGgfLyPHmY9/zuU53smuMw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{ asset('theme-new/script/components.js') }}"></script>
<script src="{{ asset('theme-new/index.js') }}"></script>

@if ($statusMessage = Session::get('success'))
    <script>
        notifier.show('Success!', '{!! $statusMessage !!}', 'success', successImg, 4000);
    </script>
@endif
@if ($statusMessage = Session::get('error'))
    <script>
         notifier.show('Error!', '{!! $statusMessage !!}', 'error', errorImg, 4000);
    </script>
@endif


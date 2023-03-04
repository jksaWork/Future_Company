
<!DOCTYPE html>
<html lang="en"
direction="{{ app()->getLocale() == 'en' ?: 'rtl' }} " dir="{{ app()->getLocale() == 'en' ?: 'rtl' }}"
>
	<!--begin::Head-->
	<head><base href="../../../">
		<title> Future Comapny</title>
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Global Stylesheets Bundle(used by all pages)-->
		<link href="{{ asset('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
		<!--end::Global Stylesheets Bundle-->
        @

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500&family=El+Messiri&display=swap"
        rel="stylesheet">
    <style>
        * {
            font-family: 'Cairo', sans-serif;
            font-family: 'El Messiri', sans-serif;
        }
    </style>
    </head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="bg-light rtl">
		<!--begin::Main-->
		<!--begin::Root-->
        <x:notify-messages />
		@yield('content')
		<!--end::Root-->
		<!--end::Main-->
		<!--begin::Javascript-->
        @notifyJs
		<script>var hostUrl = "assets/";</script>
		<!--begin::Global Javascript Bundle(used by all pages)-->
		<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}}"></script>
		<script src="{{ asset('assets/js/scripts.bundle.js')}}"></script>
		<!--end::Global Javascript Bundle-->
		<!--begin::Page Custom Javascript(used by this page)-->
		<script src="{{ asset('assets/js/custom/authentication/sign-in/general.js') }}"></script>
		<!--end::Page Custom Javascript-->
		<!--end::Javascript-->
	</body>
	<!--end::Body-->
</html>

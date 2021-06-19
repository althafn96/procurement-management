
<!DOCTYPE html>
<html lang="en">
	<!--begin::Head-->
	<head>
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta charset="utf-8" />
		<title>{{ $title['page'] ?? '' }} | {{ config('app.name') }}</title>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Page Vendors Styles(used by this page)-->
		{{ $styles ?? '' }}
		<!--end::Page Vendors Styles-->
		<!--begin::Global Theme Styles(used by all pages)-->
		<link href="{{ global_asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ global_asset('assets/plugins/custom/prismjs/prismjs.bundle.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ global_asset('assets/tenants/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
		<!--end::Global Theme Styles-->
		<!--begin::Layout Themes(used by all pages)-->
		<!--end::Layout Themes-->
		<link rel="shortcut icon" href="{{ global_asset('assets/media/logos/favicon.ico') }}" />
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" style="background-image: url({{ global_asset('assets/media/bg/bg-10.jpg') }})" class="quick-panel-right demo-panel-right offcanvas-right header-fixed subheader-enabled page-loading">
		<!--begin::Main-->
		<!--begin::Header Mobile-->
        @include('tenants.layouts.partials._header_mobile')
		<!--end::Header Mobile-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Page-->
			<div class="d-flex flex-row flex-column-fluid page">
				<!--begin::Wrapper-->
				<div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
					<!--begin::Header-->
                    @include('tenants.layouts.partials._header')
					<!--end::Header-->
					<!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						{{ $slot ?? '' }}
					</div>
					<!--end::Content-->
					<!--begin::Footer-->
                    @include('tenants.layouts.partials._footer')
					<!--end::Footer-->
				</div>
				<!--end::Wrapper-->
			</div>
			<!--end::Page-->
		</div>
		<!--end::Main-->
		<!-- begin::User Panel-->
        {{-- @include('tenants.layouts.partials._user_panel') --}}
		<!-- end::User Panel-->
		<!--begin::Quick Panel-->
        {{-- @include('tenants.layouts.partials._quick_panel') --}}
		<!--end::Quick Panel-->
		<!--begin::Chat Panel-->
        {{-- @include('tenants.layouts.partials._chat_panel') --}}
		<!--end::Chat Panel-->
		<!--begin::Scrolltop-->
        {{-- @include('tenants.layouts.partials._scrolltop') --}}
		<!--end::Scrolltop-->
		<!--begin::Sticky Toolbar-->
        {{-- @include('tenants.layouts.partials._sticky_toolbar') --}}
		<!--end::Sticky Toolbar-->
		<!--begin::Demo Panel-->
        {{-- @include('tenants.layouts.partials._demo_panel') --}}
		<!--end::Demo Panel-->
		<script>var HOST_URL = "";</script>
		<!--begin::Global Config(global config for global JS scripts)-->
		<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#6993FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#F3F6F9", "dark": "#212121" }, "light": { "white": "#ffffff", "primary": "#E1E9FF", "secondary": "#ECF0F3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#212121", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121" } }, "font-family": "Poppins" };</script>
		<!--end::Global Config-->
		<!--begin::Global Theme Bundle(used by all pages)-->
		<script src="{{ global_asset('assets/plugins/global/plugins.bundle.js') }}"></script>
		<script src="{{ global_asset('assets/plugins/custom/prismjs/prismjs.bundle.js') }}"></script>
		<script src="{{ global_asset('assets/tenants/js/scripts.bundle.js') }}"></script>
		<script src="{{ global_asset('assets/tenants/js/custom.js') }}"></script>
		<script src="{{ mix('js/app.js') }}"></script>
		<!--end::Global Theme Bundle-->
		{{ $scripts ?? '' }}
	</body>
	<!--end::Body-->
</html>

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<title>{{ config('app.name', 'Laravel') }}</title>

	<!-- Scripts -->
    <script src="{{ asset('js/app.js') }}?v={{ uniqid() }}" defer></script>

	<!-- Fonts -->
	<link rel="dns-prefetch" href="//fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

	<!-- Styles -->
	<link href="{{ asset('css/app.css') }}?v={{ uniqid() }}" rel="stylesheet">
</head>

<body>
	<div id="app">
		@if(auth()->check())
        <nav-bar user="{{auth()->user()}}"></nav-bar>
		@endif

		@yield('content')

		@if(auth()->check())
		@include('partial.footer')
		@endif

	</div>
	<script type="module" src="https://unpkg.com/ionicons@5.0.0/dist/ionicons/ionicons.esm.js"></script>
</body>

</html>

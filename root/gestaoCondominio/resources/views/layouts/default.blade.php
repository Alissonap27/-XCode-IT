<!DOCTYPE html>
<html lang="pt-br">
	<head>
		@include('layouts.main.head')
	</head>
	<body>
		<header>
            @include('layouts.main.header-navbar')
		</header><br><br><br>
		<main class="container">
            @yield('content')
            <div class="container">
                <div class="col-md-12 text-center">
                </div>
            </div>
		</main>

		<br>

		<footer>
			@include('layouts.main.footer')
		</footer>

		@stack('start-scripts')
        <script src="{{ asset(('js/all.js')) }}"></script>
		@stack('final-scripts')
	</body>
</html>

<!DOCTYPE html>
<html>
<x-head />

<body class="dark-mode">
	<div class="wrapper" id="app">

        <x-navbar />

        <x-sidebar />

        @yield('content')

        
	</div>
</body>
@yield('scripts')
</html>
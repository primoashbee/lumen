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

<script defer>
        window.addEventListener('DOMContentLoaded', function() {
                setTimeout((x)=>{
                        
                        $('#sidebar-toggle')
                },100)
                
        },(jQuery))

</script>
</html>
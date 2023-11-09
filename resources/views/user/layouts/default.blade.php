<!DOCTYPE html>
<html>
    @include('user.includes.head')

    <body class="bg-gray-100">
        @include('user.includes.header')

        @yield('content')

        @include('user.includes.footer')
    </body>
</html>

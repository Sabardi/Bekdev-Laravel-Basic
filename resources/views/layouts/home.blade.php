<!DOCTYPE html>
<html lang="en">
@include('includes.style')
@stack('after-style')

<body style="background: lightgray" id="loading">

    {{-- start navbar --}}

    {{-- end navbar --}}

    {{-- sidebar --}}

    {{-- content --}}
    @yield('content')

    {{-- @include('includes.footer') --}}
    @include('includes.script')
    @stack('after-script')
</body>

</html>

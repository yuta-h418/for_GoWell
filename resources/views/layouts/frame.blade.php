<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="Content-Script-Type" content="text/javascript">
    <meta http-equiv="Content-Style-Type" content="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @stack('head')
    <link rel="stylesheet" href="{{ asset('/css/admin_common_style.css?20220407') }}" type="text/css">
    @stack('style')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
    @stack('script')
    <title>@isset($pageTitle){{ 0 < strlen($pageTitle) ? "{$pageTitle} |" : '' }}@endisset for_GoWell</title>
</head>
<body @isset($bodyAttributes) @foreach((array) $bodyAttributes as $k => $v) {{ $k }}="{{ $v }}"@endforeach @endisset>
    @if(!preg_match('/^relate_customer/', Route::currentRouteName()))
        @include('menus.main')
    @endif
        @yield('contents')

</body>
</html>

<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Paloit - @yield('title')</title>
    <link rel="stylesheet" href="{{asset('css/employee.css')}}" />
    <script src="{{asset('js/employee.jquery-3.4.1.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('js/employee.js')}}" type="text/javascript"></script>
</head>
<body>
<header>
    <a href="{{url('/employees')}}">Home</a>
</header>
    @yield('content')
<footer></footer>
</body>
</html>
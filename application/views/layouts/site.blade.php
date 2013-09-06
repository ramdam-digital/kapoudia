<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=9">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>{{Ramdam::getOption('sitename')}} @if(isset($title)) - {{$title}} @endif</title>
    <link href='http://fonts.googleapis.com/css?family=Cabin' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
    <link href="{{URL::base()}}/css/style.css" rel="stylesheet" type="text/css">
    @yield('styles')
    <link rel="stylesheet" href="{{URL::base()}}/css/mediumscreen.css" type="text/css" />
    <link rel="stylesheet" href="{{URL::base()}}/css/smallscreen.css" type="text/css" />
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>

    
</head>

<body>

<header>
<div id="top">
    <a href="{{URL::home()}}"><img src="{{URL::base()}}/img/logo.png" class="logo" alt=" "></a>
    
    @include('blocks.top')
    

    <!--<div id="acces_pro"><span></span><a href="{{URL::to_route('acces_pro')}}">{{Lang::line('kapoudia.Acces')->get()}}</a></div>-->
    
    @include('blocks.menu')

</div>
</header>

<section>
@yield('content')
</section>

@include('blocks.footer')


<script type="text/javascript" src="{{URL::base()}}/js/menu.js"></script>
@yield('scripts')
<script type="text/javascript">
$(document).ready(function() {
    menu();
    @yield('ready')
});

</script>

</body>
</html>
@layout('layouts.site')

@section('styles')
<link href="{{URL::base()}}/css/scroll.css" rel="stylesheet" type="text/css">
@endsection

@section('content')
<div id="white-head"></div>
<div id="white">

    @if(count($slides)>0)
    <div id="slider">
        

        <img class="left" id="prev" src="{{URL::base()}}/img/left.png" alt=" ">
        <img class="right" id="next" src="{{URL::base()}}/img/right.png" alt=" ">
        <div id="slides">
            <ul>
                @foreach($slides as $s)
                <li><img src="{{Ramdam::getUploadDir()}}{{$s->path}}" alt=" "></li>
                
                @if(count($slides)==1)
                <li><img src="{{Ramdam::getUploadDir()}}{{$s->path}}" alt=" "></li>
                <li><img src="{{Ramdam::getUploadDir()}}{{$s->path}}" alt=" "></li>
                @endif

                @endforeach

                @if(count($slides)==2)
                @foreach($slides as $s)
                <li><img src="{{Ramdam::getUploadDir()}}{{$s->path}}" alt=" "></li>
                @endforeach
                @endif
            </ul>
            <div class="clear"></div>
        </div>
    </div>
    @endif


    <div class="clear" style="height:200px;"></div>
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="{{URL::base()}}/js/slider.js"></script>
@endsection

@section('ready')
slider();
@endsection

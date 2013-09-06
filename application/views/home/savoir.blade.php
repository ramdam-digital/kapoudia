@layout('layouts.site')

@section('styles')
<link href="{{URL::base()}}/css/scroll.css" rel="stylesheet" type="text/css">
<link href="{{URL::base()}}/css/faire.css" rel="stylesheet" type="text/css">
@endsection

@section('content')

<div id="wood-head"></div>
<div id="wood">

<div id="limiter">
        
        

<div class="left">
    <h2 class="title">{{$page->title}}</h2>
    <div class="scroll scroll-left">
        <div class="scrollbar"><div class="thumb thumb_white"></div></div>
        <div class="viewport">
             <div class="overview">
                {{$page->content}}
            </div>
        </div>
    </div>  
</div>


<div class="right">
	@if(isset($images[0]) && !empty($images[0]->path))
        <img  class="slide" id="rightImg" src="{{Ramdam::getUploadDir()}}{{$images[0]->path}}">
    @endif
</div>

<div class="clear"></div>

    </div>

</div>
@endsection

@section('scripts')
<script type="text/javascript" src="{{URL::base()}}/js/jquery.tinyscrollbar.min.js"></script>
@endsection

@section('ready')
$('.scroll').tinyscrollbar();
@endsection

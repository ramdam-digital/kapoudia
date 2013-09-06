@layout('layouts.site')

@section('styles')
<link href="{{URL::base()}}/css/scroll.css" rel="stylesheet" type="text/css">
<link href="{{URL::base()}}/css/terre.css" rel="stylesheet" type="text/css">
@endsection

@section('content')
<div id="white-head"></div>
<div id="white">

<div id="limiter">
        <article>
        

    <h2 class="title">{{$page->title}}</h2>
    <div class="scroll scroll-large">
        <div class="scrollbar"><div class="thumb thumb_white"></div></div>
        <div class="viewport">
             <div class="overview">
                {{$page->content}}    
			</div>
        </div>
    </div>  

</article>
    </div>
<div class="clear" style="height:200px;"></div>
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="{{URL::base()}}/js/jquery.tinyscrollbar.min.js"></script>
@endsection

@section('ready')
$('.scroll').tinyscrollbar();
@endsection

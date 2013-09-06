@layout('layouts.site')

@section('styles')
<link href="{{URL::base()}}/css/scroll.css" rel="stylesheet" type="text/css">
<link href="{{URL::base()}}/css/acces.css" rel="stylesheet" type="text/css">
@endsection

@section('content')
<div id="white-head"></div>
<div id="white">
<div id="limiter">
    <article>
    <h2 class="title">{{Lang::line('kapoudia.text3')->get()}}</h2>


    <div class="scroll scroll-large">
        <div class="scrollbar"><div class="thumb"></div></div>
        <div class="viewport">
             <div class="overview">

                {{$page->content}}
                                     
            </div>
        </div>
    </div>  


        <div class="center margin_top10" id="buttons">
        	<a href="{{URL::to_route('fiche_pro')}}" class="btn">{{Lang::line('kapoudia.text4')->get()}}</a>
        	<a href="{{URL::to_route('contact')}}" class="btn">{{Lang::line('kapoudia.contact')->get()}}</a>
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

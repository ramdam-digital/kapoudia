@layout('layouts.site')

@section('styles')
<link href="{{URL::base()}}/css/produits.css" rel="stylesheet" type="text/css">
@endsection

@section('content')


<div id="white-head"></div>
<div id="white">
<div id="limiter">
    <article>


<div id="slider1">
        <div class="viewport">
            <ul class="overview">
                @foreach($products as $p)
                <li>
                    <a class="buy" href="{{URL::to_route('show_product', array(Ramdam::getSlug($menu->label), $menu->id, $p->id))}}">{{Lang::line('login.acheter')->get()}}</a>
                    <table>
                        <tr><td class="img"><img src="{{Ramdam::getUploadDir()}}{{$p->image}}" /></td></tr>
                        <tr><td><h3>{{$p->label}}</h3></td></tr>
                        <tr><td><p>{{$p->description}}</p></td></tr>
                    </table>
                </li>
                @endforeach
                
            </ul>
            <img  id="prev" class="prev" src="{{URL::base()}}/img/left.png" alt=" ">
            <img  id="next" class="next" src="{{URL::base()}}/img/right.png" alt=" ">
        </div>
        
    </div>


    <div class="separetor"></div>


    <div id="productIcon">
        <div class="iconElement new">
            <img src="{{URL::base()}}/slides/square.png" alt="" />
        </div>

        @foreach($products as $p)
        @if($p->image2)
        <a href="{{URL::to_route('show_product', array(Ramdam::getSlug($menu->label), $menu->id, $p->id))}}">
        <div class="iconElement">
            <img src="{{Ramdam::getUploadDir()}}{{$p->image2}}" alt="" />
        </div>
        </a>
        @endif
        @endforeach


        
        
    </div>

     
    </article>
</div>
    <div class="clear" style="height:200px;"></div>
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="{{URL::base()}}/js/jquery.tinycarousel.min.js"></script>

@endsection

@section('ready')
$('#slider1').tinycarousel();
$('#slider1 .overview li').mouseover(function() {

    $( "#slider1 .overview li" ).each(function() {
      $(this).children(".buy").css( "display", "none" );
      $(this).children("p").css( "color", "#666" );
    });

    $(this).children(".buy").css('display', 'block');
    $(this).children("p").css( "color", "#000" );
});
@endsection

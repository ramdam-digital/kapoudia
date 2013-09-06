@layout('layouts.site')

@section('styles')
<link href="{{URL::base()}}/css/produit.css" rel="stylesheet" type="text/css">
@endsection

@section('content')

<div id="white-head"></div>
<div id="white">

<div id="limiter">
   <article>

        <div id="topPart">
            

            <img  id="prev" src="{{URL::base()}}/img/left.png" alt=" ">
            <img  id="next" src="{{URL::base()}}/img/right.png" alt=" ">
            
            <div id="thumb"> 
                @foreach($produits as $k=>$p)
                <img id="img{{$k+1}}" src="{{$p->image}}" />
                @endforeach

             </div>
            <div id="description"> 
                <h1>{{$page->title}}</h1>
                {{$page->description}}
            </div>
            <div id="detaille"> 
                <div id="prix">
                    <ul>
                        @foreach($produits as $k=>$p)
                        <li id="price{{$k+1}}">
                            <span class="size">{{$p->volume}}</span>
                            {{$p->price}} €
                            <span>{{$p->price2}} $</span>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div id="nbr">
                    <div> <img src="{{URL::base()}}/img/unit.png"/> <div class="label"> Unit </div> </div>
                    <div> <img src="{{URL::base()}}/img/case.png"/> <div class="label"> Case </div> </div>
                    <div> <img src="{{URL::base()}}/img/pack.png"/> <div class="label"> Pack </div> </div>
                </div>
                <form >
                    <label for="package" name="package">Package : </label>
                    <select name="package">
                        <option value="unit">Unit</option>
                        <option value="case">Case</option>
                    </select>



                    <label for="quantite">{{Lang::line('kapoudia.quantité')->get()}} : </label>
                    @foreach($produits as $k=>$p)
                    <input type="hidden" name="id{{$k+1}}" id="id{{$k+1}}" value="{{$p->id}}"> 
                    @endforeach
                    <input type="text" id="quantite" name="quantite" value="0" />
                    <input type="button" value="+" id="up_panier" />
                    <input type="button" value="-" id="down_panier" />
                    <input type="hidden" name="current_product" id="current_product" value="{{$produits[0]->id}}"> 
                    <input type="submit" value="{{Lang::line('kapoudia.ajouter')->get()}}" id="add_panier" />
                </form>
                <div id="panier-msg">
                Votre <a href="{{URL::to_route('cart')}}">panier</a>  est mis à jour.
                </div>
            </div>
        </div>
        <div id="bottomPart">
            <div id="bottomLeft">
            
            {{$page->content}}

            </div>
            <div id="bottomRight">
                <div id="region">
                    <h3>{{$specs[4]['label']}} : </h3>
                    <span>{{$specs[4]['value']}}</span>
                </div>
                <div id="variete">
                    <h3>{{$specs[3]['label']}} : </h3>
                    <span>{{$specs[3]['value']}}</span>
                </div>
                <div id="degustation">
                    <h3>{{$specs[2]['label']}} : </h3>
                    <span>{{$specs[2]['value']}}</span>
                </div>
                <div id="vote">
                    <h3>{{$specs[1]['label']}} : </h3>
                    <span>{{$specs[1]['value']}}</span>
                </div>
                <div id="remporter">
                    <h3>{{$specs[0]['label']}} : </h3>
                    <span>{{$specs[0]['value']}}</span>
                </div>

            </div>
        </div>

    </article>
</div>
    <div class="clear" style="height:200px;"></div>
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="{{URL::base()}}/js/produits.js"></script>
@endsection

@section('ready')

var BASE = '{{URL::base()}}/';

slide_product();

add_panier(BASE);

@endsection

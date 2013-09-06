<div id="top-menu">
    <div id="lang"><a href="{{URL::to_route('change_lang', array('fr'))}}">Fr</a> | <a href="{{URL::to_route('change_lang', array('en'))}}">En</a></div>
    <div id="menu">
        <ul>
           <li> <a href="{{URL::to_route('contact')}}"> <img src="{{URL::base()}}/img/nous-contacter.png" alt=" "> {{Lang::line('kapoudia.contact1')->get()}}</a></li>
            <li> <a href="{{URL::to_route('cart')}}"> <img src="{{URL::base()}}/img/panier.png" alt=" "> {{Lang::line('kapoudia.panier')->get()}}</a></li>
            <li> <a href="{{URL::to_route('search')}}"> <img src="{{URL::base()}}/img/recherche.png" alt=" "> {{Lang::line('kapoudia.recherche')->get()}}</a></li>
            <li class="last"><a href="{{URL::to_route('member_login')}}"> <img src="{{URL::base()}}/img/inscription.png" alt=" "> {{Lang::line('kapoudia.compte')->get()}} </a></li>
        </ul>
    </div>
    <div class="clear"></div>
</div>
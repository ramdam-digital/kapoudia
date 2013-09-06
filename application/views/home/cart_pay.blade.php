@layout('layouts.site')

@section('styles')
<link href="{{URL::base()}}/css/panier.css" rel="stylesheet" type="text/css">
@endsection

@section('content')
<div id="white-head"></div>
<div id="white">
    <div id="panierMenu">
        <div class="panierElement panier">{{Lang::line('kapoudia.panier')->get()}}</div>
        <div class="panierElement paiment active">{{Lang::line('kapoudia.paiement')->get()}}</div>
        <div class="panierElement confirmation">{{Lang::line('kapoudia.confirmation')->get()}}</div>
    </div>
    <div id="panierContainer">
        <div id="panierLeft">
            <div class="leftElement">
                <h3>{{Lang::line('kapoudia.af')->get()}}</h3>
                <p>Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem IpsumLorem  Lorem IpsumLorem Ipsum</p>
            </div>
            <div class="leftElement">
                 <h3>{{Lang::line('kapoudia.besoin')->get()}} </h3>
                 <p>{{Lang::line('kapoudia.appelez')->get()}} </p>
            </div>
        </div>
        <div id="panierRight">
            <table class="noborder">
 
                <tr>
                    <td>{{Lang::line('kapoudia.nomprenom')->get()}}</td>
                    <td>{{$user->nom}} {{$user->prenom}}</td>
                </tr>
                <tr>
                    <td>{{Lang::line('login.adresse')->get()}}</td>
                    <td>{{$user->adresse}}</td>
                </tr>
                <tr>
                    <td>{{Lang::line('login.cp')->get()}}</td>
                    <td>{{$user->cp}}</td>
                </tr>
                <tr>
                    <td>{{Lang::line('login.tel')->get()}}</td>
                    <td>{{$user->tel}}</td>
                </tr>
                <tr>
                    <td><a href="{{URL::to_route('cart')}}" class="next_cart" style="font-size:12px;">&laquo;{{Lang::line('login.retour')->get()}} </a></td>
                    <td>
                    <a href="#" class="next_cart">&raquo; {{Lang::line('login.modifier')->get()}}</a>
                    </td>
                </tr>


            </table>

        </div>
    </div>
    <div class="clear" style="height:200px;"></div>
</div>
@endsection

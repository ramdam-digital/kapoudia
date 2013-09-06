@layout('layouts.site')

@section('styles')
<link href="{{URL::base()}}/css/panier.css" rel="stylesheet" type="text/css">
@endsection

@section('content')
<div id="white-head"></div>
<div id="white">
    <div id="panierMenu">
        <div class="panierElement panier active"> {{Lang::line('kapoudia.panier')->get()}}</div>
        <!--<div class="panierElement connexion"> Connexion </div>-->
        <!--<div class="panierElement livraison"> Livraison </div>-->
        <div class="panierElement paiment">{{Lang::line('kapoudia.paiement')->get()}}  </div>
        <div class="panierElement confirmation"> {{Lang::line('kapoudia.confirmation')->get()}} </div>
    </div>
    <div id="panierContainer">
        <div id="panierLeft">
            <div class="leftElement">
                <h3>{{Lang::line('kapoudia.af')->get()}}</h3>
                <p>{{Lang::line('kapoudia.panier')->get()}}Lorem Ipsum Lorem Ipsum Lorem Ipsum Lorem IpsumLorem  Lorem IpsumLorem Ipsum</p>
            </div>
            <div class="leftElement">
                 <h3>{{Lang::line('kapoudia.besoin')->get()}}</h3>
                 <p>{{Lang::line('kapoudia.appelez')->get()}}</p>
            </div>
        </div>
        <div id="panierRight">
            <table>
                <tr>
                    <th>{{Lang::line('kapoudia.produit')->get()}}</th>
                    <th>{{Lang::line('kapoudia.quantité')->get()}}</th>
                    <th>{{Lang::line('kapoudia.prix')->get()}}</th>
                    <th>{{Lang::line('kapoudia.tva')->get()}}</th>
                    <th>{{Lang::line('kapoudia.ttc')->get()}}</th>
                    <th>{{Lang::line('kapoudia.total')->get()}} </th>
                </tr>
                @if(count($cart)==0)
                <tr>
                    <td colspan="6" style="padding: 20px;">
                        {{Lang::line('kapoudia.vide')->get()}}
                    </td>
                </tr>
                @else
                    @foreach($cart as $p)
                    <tr>
                        <td>
                            <img src="{{$p->image}}">
                            <p>{{$p->label}}</p> 
                        </td>
                        <td>{{$p->quantite}}</td>
                        <td>{{$p->unit_price}} {{$devise}}</td>
                        <td>{{$p->tva}} %</td>
                        <td>{{$p->price_ttc}} {{$devise}}</td>
                        <td>{{$p->total_price}} {{$devise}}</td>
                    </tr>
                    @endforeach
                    <tr>
                            <td style="padding:5px 0;"><strong>{{Lang::line('kapoudia.total1')->get()}}</strong></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td style="padding:5px 0;">{{$total}} {{$devise}} </td>
                        </tr>
                        <tr>
                            <td><a href="{{URL::to_route('cart_empty')}}" class="next_cart" style="font-size:12px;">{{Lang::line('kapoudia.vider')->get()}}</a></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                            <a href="{{URL::to_route('cart_pay')}}" class="next_cart">&raquo; {{Lang::line('kapoudia.suivant')->get()}}</a>
                            </td>
                        </tr>

                @endif

            </table>

        </div>
    </div>
    <div class="clear" style="height:200px;"></div>
</div>
@endsection

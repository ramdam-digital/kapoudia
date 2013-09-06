@layout('layouts.site')

@section('styles')
<link href="{{URL::base()}}/css/connexion.css" rel="stylesheet" type="text/css">
@endsection

@section('content')
<div id="white-head"></div>
<div id="white">
    <h1 style="color:#1fb25a;padding:10px;margin: 0;">{{Lang::line('kapoudia.venue')->get()}} {{$user->username}}</h1>
    <a style="color:#444;padding:10px;margin: 0;" href="{{URL::to_route('acces_pro')}}">{{ucfirst(Lang::line('kapoudia.Acces')->get())}}</a><br><br>
    <a style="color:#444;padding:10px;margin: 0;" href="{{URL::to_route('member_logout')}}">{{Lang::line('login.logout')->get()}}</a>


	<div class="connexion">
                


                @if(Session::has('message'))
                <p class="msg-success">{{ Session::get('message') }}</p>
                @endif
                @if(Session::has('fail'))
                <p class="msg-error">{{ Session::get('erreur') }}</p>
                @endif

                @foreach($errors->messages as $m)
                <p class="msg-error">{{$m[0]}}</p>
                @endforeach
    
    {{Form::open(URL::to_route('member_profile_update'), 'PUT')}}
            {{Form::hidden('id', $user->id)}}
            
            <p><label for="nom">{{Lang::line('login.nom')->get()}} </label><input type="text"  class="text short" id="nom" name="nom" value="{{$user->nom}}"></p>
            <p><label for="prenom">{{Lang::line('login.prenom')->get()}} </label><input type="text"  class="text short" id="prenom" name="prenom" value="{{$user->prenom}}"></p>
            <p><label for="entreprise">{{Lang::line('login.entreprise')->get()}}</label><input type="text"  class="text short" id="entreprise" name="entreprise" value="{{$user->entreprise}}"></p>
            <p><label for="matricule">{{Lang::line('login.matricule')->get()}} </label><input type="text"  class="text short" id="matricule" name="matricule" value="{{$user->matricule}}"></p>
            
            <p>
                <label class="select" for="activite">
                    {{Form::select('activite', $acts, $user->activite)}}
                </label>
                <div class="clear"></div>
            </p>
            <p><label for="adresse">{{Lang::line('login.adresse')->get()}} </label><input type="text"  class="text short" id="adresse" name="adresse" value="{{$user->adresse}}"></p>
            <p><label for="cp">{{Lang::line('login.cp')->get()}} </label> <input type="text"  class="text short" id="cp" name="cp" value="{{$user->cp}}"></p>
            <p><label for="tel">{{Lang::line('login.tel')->get()}}</label><input type="text"  class="text short" id="tel" name="tel" value="{{$user->tel}}"></p>
			<p>
                <label class="select" for="devise">
                    {{Form::select('devise', array('eur'=>'Euro', 'usd'=>'Dollar'), $user->devise)}}
                </label>
                <div class="clear"></div>
            </p>
            <p><input type="submit" value="{{Lang::line('login.modifier')->get()}}" class="btn"></p>
        </form>
    </div>

</div>
@endsection

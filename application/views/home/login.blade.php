@layout('layouts.site')

@section('styles')
<link href="{{URL::base()}}/css/connexion.css" rel="stylesheet" type="text/css">
@endsection

@section('content')
<div id="white-head"></div>
<div id="white">
    <div class="connexion">

        {{Form::open(URL::to_route('member_access'))}}
            <p class="title"> {{Lang::line('login.welcome')->get()}}</p><hr>
            <p class="description">{{Lang::line('login.text')->get()}}</p>
            <p><label for="username">{{Lang::line('login.username')->get()}}</label><input type="text" class="text" name="username" value=""></p>
            <p><label for="password">{{Lang::line('login.password')->get()}} </label><input type="password"  class="text short" name="password" value=""></p>
            <p><input type="submit" value="{{Lang::line('login.identifiez')->get()}}" class="btn"></p>
        </form>

        
            <p class="title" id="newAccount">{{Lang::line('login.text1')->get()}}</p><hr>

            <?php
           
            $params = array('id'=>'form-signup');
            if(count($errors->messages)>0 || Session::has('message') || Session::has('fail')) $params['style'] = 'display:block;';
            ?>
        {{Form::open(URL::to_route('member_suscribe'), 'POST', $params)}}
            <p class="description">{{Lang::line('login.text2')->get()}}</p>

                
                @if(Session::has('message'))
                <p class="msg-success">{{ Session::get('message') }}</p>
                @endif
                @if(Session::has('fail'))
                <p class="msg-error">{{ Session::get('erreur') }}</p>
                @endif

                @foreach($errors->messages as $m)
                <p class="msg-error">{{$m[0]}}</p>
                @endforeach

            <p><label for="username">{{Lang::line('login.username')->get()}} </label><input type="text" class="text" id="username" name="username" value=""></p>
            <p><label for="email">Email </label><input type="text" class="text" id="email" name="email" value=""></p>
            <p><label for="pass">{{Lang::line('login.pass')->get()}}</label><input type="password"  class="text short" id="pass" name="pass" value=""></p>
            <p><label for="repass"> {{Lang::line('login.repass')->get()}}</label><input type="password"  class="text short" id="repass" name="repass" value=""></p>
            <hr>
            
            <p><label for="nom">{{Lang::line('login.nom')->get()}}</label><input type="text"  class="text short" id="nom" name="nom" value=""></p>
            <p><label for="prenom"> {{Lang::line('login.prenom')->get()}}</label><input type="text"  class="text short" id="prenom" name="prenom" value=""></p>
            <p><label for="entreprise">{{Lang::line('login.entreprise')->get()}} </label><input type="text"  class="text short" id="entreprise" name="entreprise" value=""></p>
            <p><label for="matricule">{{Lang::line('login.matricule')->get()}} </label><input type="text"  class="text short" id="matricule" name="matricule" value=""></p>
            
            <p>
                <label class="select" for="activite">
                    <select name="activite" id="activite">
                        <option value="0">{{Lang::line('login.activite')->get()}} </option>
                        <option value="{{Lang::line('login.importateur')->get()}}">{{Lang::line('login.importateur')->get()}} </option>
                        <option value="{{Lang::line('login.grossiste')->get()}}">{{Lang::line('login.grossiste')->get()}}</option>
                        <option value="{{Lang::line('login.distributeur')->get()}}">{{Lang::line('login.distributeur')->get()}}</option>
                        <option value="{{Lang::line('login.epiceriefine')->get()}}">{{Lang::line('login.epiceriefine')->get()}}</option>
                        <option value="{{Lang::line('login.autre')->get()}}">{{Lang::line('login.autre')->get()}}</option>
                    </select>
                </label>
                <div class="clear"></div>
            </p>
            <p><label for="adresse"> {{Lang::line('login.adresse')->get()}}</label><input type="text"  class="text short" id="adresse" name="adresse" value=""></p>
            <p><label for="cp">{{Lang::line('login.cp')->get()}} </label><input type="text"  class="text short" id="cp" name="cp" value=""></p>
            <p><label for="tel">{{Lang::line('login.tel')->get()}} </label><input type="text"  class="text short" id="tel" name="tel" value=""></p>
            <p>
                {{Form::image(LaraCaptcha\Captcha::img(), 'captcha', array('class' => 'captchaimg'))}}
                <div class="clear"></div>
                <label for="captcha_user">Captcha </label>{{Form::text('captcha_user', '', array('class' => 'text'))}}

            </p>
            <p><input type="submit" value="{{Lang::line('login.inscrivez')->get()}}" class="btn"></p>
        </form>

    </div>
</div>

@endsection

@section('ready')
$("#newAccount").click(function(){
    $('#form-signup').slideToggle();
});
@endsection
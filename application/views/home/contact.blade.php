@layout('layouts.site')

@section('styles')
<link href="{{URL::base()}}/css/contact.css" rel="stylesheet" type="text/css">
@endsection

@section('content')
<div id="white-head"></div>
<div id="white">
    <div id="limiter">
        <div class="contact">
        <div class="left">
            <h2>Contact</h2>


                {{ Form::open(URL::to_route('contact_action'), 'POST', array('class'=>'contact-form')) }}


                @if(Session::has('message'))
                <p class="msg-success">{{ Session::get('message') }}</p>
                @endif
                @if(Session::has('erreur'))
                <p class="msg-error">{{ Session::get('erreur') }}</p>
                @endif
                {{ $errors->first('nom', '<p class="msg-error">:message</p>') }}
                {{ $errors->first('email', '<p class="msg-error">:message</p>') }}
                {{ $errors->first('sujet', '<p class="msg-error">:message</p>') }}
                {{ $errors->first('message', '<p class="msg-error">:message</p>') }}
                {{ $errors->first('captcha_user', '<p class="msg-error">:message</p>') }}


                    <p><label for="nom">{{Lang::line('kapoudia.nom')->get()}} </label><input type="text" id="nom" class="text" name="nom" value="{{Input::old('nom')}}" /></p>
                    <p><label for="email"> E-mail</label><input type="text" id="email" class="text" name="email" value="{{Input::old('email')}}"  /></p>
                    <p><label for="sujet">{{Lang::line('kapoudia.sujet')->get()}}</label><input type="text" id="sujet" class="text" name="sujet" value="{{Input::old('sujet')}}"  /></p>
                    <p><label for="message">Message </label><textarea class="area" name="message">{{Input::old('message')}}</textarea></p>
                    <p>
                    {{Form::image(LaraCaptcha\Captcha::img(), 'captcha', array('class' => 'captchaimg'))}}
                    <div class="clear"></div>
                    <label for="captcha_user">Captcha </label>{{Form::text('captcha_user', '', array('class' => 'text'))}}
                    </p>
                <div class="clear"></div>


                <p>
                    <input type="submit" value="{{Lang::line('kapoudia.envoyer')->get()}}"  teclass="btn">
                </p>
            </form>
        
        </div>
        <div class="right">
            <div id="map"></div>
        </div>

        </div>
        
    </div>
    <div class="clear" style="height:200px;"></div>
</div>
@endsection

@section('scripts')
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<script>

function initialize(lat, lng, canvas) {
    var map;
    var latLng = new google.maps.LatLng(lat, lng);
    var mapOptions = {
        zoom: 12,
        center: latLng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    map = new google.maps.Map(document.getElementById(canvas),
    mapOptions);

    var marker = new google.maps.Marker({
        position: latLng,
        map: map
    });

    var contentMarker = '<div class="infobulle"><p>Adresse : 10 Street Name - Tunisia</p><p>Tel : +216 23 755 465</p>  <p>Mail : digital@ramdam.in</p></div>';
 
    var infoWindow = new google.maps.InfoWindow({
        content  : contentMarker,
        position : latLng
    });

    infoWindow.open(map,marker);

}

google.maps.event.addDomListener(window, 'load', initialize(36.855, 10.189,'map'));

</script>
@endsection

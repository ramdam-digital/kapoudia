@layout('layouts.site')

@section('styles')
<link href="{{URL::base()}}/css/degustation.css" rel="stylesheet" type="text/css">
@endsection

@section('content')
<div id="wood-head"></div>
<div id="wood">
    <div id="contentTop"> <img src="{{URL::base()}}/img/backgroundTop.png"/> </div>
    <div id="content">
        <div id="textWrapper">
            <h1 class="essential">{{$data[1]}}</h1>
            <p>{{$data[2]}}</p>
            <h2 class="true">{{$data[3]}}</h2>
            <ul class="menuB">
                <li id="fruite">{{$data[4]}}</li>
                <li id="amer">{{$data[5]}}</li>
                <li id="piquant">{{$data[6]}}</li>
            </ul>
            <p class="detaille" id="ctn1-1">{{$data[7]}}</p>
            <p class="detaille" id="ctn1-2">{{$data[20]}}</p>
            <p class="detaille" id="ctn1-3">{{$data[21]}}</p>
            
            <div class="clear"></div>

            <h2 class="false">{{$data[8]}}</h2>
            <ul class="menuB">
                <li id="chome">{{$data[9]}}</li>
                <li id="moisissure">{{$data[10]}}</li>
                <li id="vineux">{{$data[11]}}</li>
            </ul>
            <p class="detaille" id="ctn2-1">{{$data[12]}}</p>
            <p class="detaille" id="ctn2-2">{{$data[22]}}</p>
            <p class="detaille" id="ctn2-3">{{$data[23]}}</p>


            <div class="clear"></div>
            <h1 class="bottom">{{$data[13]}}</h1>
            <ul class="menuC">
                <li id="tasting">{{$data[14]}}</li>
                <li id="coup">{{$data[15]}}</li>
                <li id="temperature">{{$data[16]}}</li>
                <li id="digest">{{$data[17]}}</li>
                <li id="classification">{{$data[18]}}</li>
            </ul>
            <p class="end"  id="ctn3-1">{{$data[19]}}</p>
            <p class="end"  id="ctn3-2">{{$data[24]}}</p>
            <p class="end"  id="ctn3-3">{{$data[25]}}</p>
            <p class="end"  id="ctn3-4">{{$data[26]}}</p>
            <p class="end"  id="ctn3-5">{{$data[27]}}</p>
        </div>
    </div>
    <div id="contentBottom"> <img src="{{URL::base()}}/img/backgroundBottom.png"/> </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="{{URL::base()}}/js/degustation.js"></script>
@endsection

@section('ready')
degustation();
@endsection

@layout('layouts.site')

@section('styles')
<link href="{{URL::base()}}/css/olivier.css" rel="stylesheet" type="text/css">
@endsection

@section('content')

<div id="white-head"></div>
<div id="white">
<div id="limiter">
    <div id="olivier">
        <div class="ecologique"><span>C'est écologique</span></div>
        <div class="adopter"><span>C'est l'adopter</span></div>
        <div class="offrir"><span>C'est l'offrir</span></div>
        <div class="visiter"><span>C'est le visiter</span></div>
    </div>
</div>
    <div class="clear" style="height:130px;"></div>
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="{{URL::base()}}/js/jquery.easing.1.3.min.js"></script>
<script type="text/javascript" src="{{URL::base()}}/js/olivier.js"></script>
@endsection

@section('ready')

olivier();

@endsection

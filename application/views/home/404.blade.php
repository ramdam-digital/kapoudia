@layout('layouts.site')

@section('styles')
<link href="{{URL::base()}}/css/scroll.css" rel="stylesheet" type="text/css">
@endsection

@section('content')
<div id="white-head"></div>
<div id="white">
	<?php 
	if(Session::has('language')){
		Config::set('application.language', Session::get('language'));
	}else{
		$lang = Ramdam::getOption('language');
		Config::set('application.language', $lang);
	}
	?>
    <h1 style="color:#1fb25a;padding:10px;margin: 0;">{{Lang::line('kapoudia.404')->get()}}</h1>
    <h3 style="color:#444;padding:10px;margin: 0;">{{Lang::line('kapoudia.404msg')->get()}}</h3>
     <div class="clear" style="height:200px;"></div>
</div>
@endsection


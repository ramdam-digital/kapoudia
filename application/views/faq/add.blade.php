@layout('layouts.admin')


@section('content')
<h3>Ajouter une question</h3>

{{Form::open(URL::to_route('create_faq'))}}

<p>
{{Form::select('category', $categories)}} 
{{Form::select('status', array(1=>'Publiée', 0=>'Non publiée'))}} 
</p>

<ul class="nav nav-tabs">

@if($current)
	<li class="active"><a href="#{{$current->lang}}" data-toggle="tab">{{$current->label}}</a></li>
@endif

@foreach($languages as $lang)
  <li><a href="#{{$lang->lang}}" data-toggle="tab">{{$lang->label}}</a></li>
@endforeach
</ul>

<div class="tab-content">

@if($current)
	<div class="tab-pane fade active in" id="{{$current->lang}}">
		<p><input type="text" class="input-xxlarge" placeholder="Question" name="{{$current->lang}}[question]"></p>
    <p><input type="text" class="input-xxlarge" placeholder="Réponse" name="{{$current->lang}}[answer]"></p>
	</div>
@endif


@foreach($languages as $lang)
  <div class="tab-pane fade" id="{{$lang->lang}}">
	<p><input type="text" class="input-xxlarge" placeholder="Question" name="{{$lang->lang}}[question]"></p>
  <p><input type="text" class="input-xxlarge" placeholder="Réponse" name="{{$lang->lang}}[answer]"></p>
  </div>
@endforeach
</div>



<p><input type="submit" class="btn btn-inverse" value="Ajouter"> <input type="reset" class="btn" value="Annuler"></p>

{{Form::close()}}

@endsection


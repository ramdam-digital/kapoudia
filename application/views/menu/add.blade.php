@layout('layouts.admin')


@section('content')
<h3>Ajouter un menu</h3>

{{Form::open(URL::to_route('create_menu'))}}

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
		<p><input type="text" class="input-xxlarge" placeholder="Libellé" name="{{$current->lang}}[label]"></p>
	</div>
@endif


@foreach($languages as $lang)
  <div class="tab-pane fade" id="{{$lang->lang}}">
	<p><input type="text" class="input-xxlarge" placeholder="Libellé" name="{{$lang->lang}}[label]"></p>
  </div>
@endforeach
<hr>
</div>

<p>
<label>Parent </label> {{Form::select('parent', $parents)}} 
</p>

<p>
<label>Type </label> {{Form::select('method', $methods)}} 
</p>

<p><input type="text" class="input" placeholder="Paramètes" name="params"></p>

<p><input type="submit" class="btn btn-inverse" value="Ajouter"> <input type="reset" class="btn" value="Annuler"></p>

{{Form::close()}}

@endsection

@layout('layouts.admin')


@section('content')
<h3>Modifier un menu</h3>

{{Form::open(URL::to_route('update_menu'), 'PUT')}}
{{Form::hidden('id', $menu->id)}}
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
		<p><input type="text" class="input-xxlarge" placeholder="Libellé" name="{{$current->lang}}[label]" value="{{$data[$current->lang]['label']}}"></p>
	</div>
@endif


@foreach($languages as $lang)
  <div class="tab-pane fade" id="{{$lang->lang}}">
	<p><input type="text" class="input-xxlarge" placeholder="Libellé" name="{{$lang->lang}}[label]" value="{{$data[$lang->lang]['label']}}"></p>
  </div>
@endforeach
<hr>
</div>

<p>
<label>Parent </label> {{Form::select('parent', $parents, $menu->parent)}} 
</p>

<p>
<label>Type </label> {{Form::select('method', $methods, $menu->method)}} 
</p>

<p><input type="text" class="input" placeholder="Paramètes" name="params" value="{{$menu->params}}"></p>

<p><input type="submit" class="btn btn-inverse" value="Modifier"> <input type="reset" class="btn" value="Annuler"></p>

{{Form::close()}}

@endsection

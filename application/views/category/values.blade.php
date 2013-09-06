@layout('layouts.admin')


@section('content')
<h3>Valeurs : {{$spec->label}}</h3>
{{Form::open(URL::to_route('update_vals_category'), 'PUT')}}
{{Form::hidden('id', $spec->id)}}
@foreach($vals as $k=>$v)
<p>Valeur {{strtoupper($k)}} : <input type="text" name="label[{{$k}}]" value="{{$v}}"></p>
@endforeach
<p><input type="submit" class="btn btn-inverse" value="Modifier"> <input type="reset" class="btn" value="Annuler"></p>
<p>
	<a class="btn btn-primary" href="{{URL::to_route('assoc_category', array($spec->category))}}">Retour</a>
</p>
{{Form::close()}}
@endsection

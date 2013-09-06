@layout('layouts.admin')


@section('content')

<h3>Affecter une page</h3>
{{Form::open(URL::to_route('add_spec_category'))}}
{{Form::hidden('id', $id)}}
<p>
	{{Form::select('page', $pages, $current)}}
</p>
<p><input type="submit" class="btn btn-inverse" value="Appliquer"></p>
<hr>
{{Form::close()}}


<h3>Associer des caractéristiques</h3>
{{Form::open(URL::to_route('add_spec_category'))}}
{{Form::hidden('id', $id)}}
<p>
	@foreach($languages as $l)
	<input type="text" value="" name="label[{{$l->lang}}]" placeholder="Libellé {{$l->label}}"/> 
	@endforeach
</p>
<p><input type="submit" class="btn btn-inverse" value="Associer"> <input type="reset" class="btn" value="Annuler"></p>
<hr>
{{Form::close()}}


<table class="table">
	<thead>
		<tr>
			<th>Specification</th>
			@foreach($languages as $l)
			<th>Libellé {{$l->label}}</th>
			@endforeach
			<th></th>
			<th></th>
		<tr>
	</thead>
	<tbody>
		@foreach($specs as $k=>$s)
		<tr>
			<td>{{$k}}</td>
			{{Form::open(URL::to_route('update_spec_category'), 'PUT')}}
			@foreach($languages as $l)
			<td>
					<input type="text" value="{{$s[$l->lang]}}" name="label[{{$l->lang}}]"/>	
					{{Form::hidden('id', $k)}}
			</td>
			@endforeach
			<td>

				<input type="submit" class="btn btn-inverse" value="Modifier"> 
				<a class="btn btn-primary" href="{{URL::to_route('values_category', array($k))}}">Valeurs</a>
				<input type="reset" class="btn" value="Annuler">
				
			</td>
			{{Form::close()}}
			<td>
				{{Form::open(URL::to_route('delete_spec_category'), 'DELETE')}}
				{{Form::hidden('id', $k)}}
				{{Form::submit('Supprimer', array('class'=>'btn btn-danger'))}}
				{{Form::close()}}
			</td>
		</tr>
		@endforeach
	</tbody>
</table>






@endsection

@layout('layouts.admin')


@section('content')
<h3>Dégustation</h3>

{{Form::open(URL::to_route('update_degustation'), 'PUT')}}

@foreach($data as $k=>$d)
  
  @foreach($languages as $l)
  <p>
    <label>{{$l->label}}</label>
    <textarea style="width: 400px;height: 100px;" name="data[{{$k}}][{{$l->lang}}]">{{$d[$l->lang]}}</textarea>
  </p>
  @endforeach

<hr style="border: 1px solid #000;">
@endforeach

<p><input type="submit" class="btn btn-inverse" value="Modifier"> <input type="reset" class="btn" value="Annuler"></p>

{{Form::close()}}

@endsection
@layout('layouts.admin')


@section('content')
<h3>Nouveau produit</h3>

{{Form::open(URL::to_route('create_product'))}}

<p>{{Form::select('category', $categories)}} </p>
<p>{{Form::select('brand', $brands)}} </p>
<p>{{Form::select('status', array(1=>'Publiée', 0=>'Non publiée'))}} </p>
</p>

<p><input type="text" class="input-xlarge" placeholder="Référence" name="reference"></p>
<p><input type="text" class="input-xlarge" placeholder="Stock" name="stock"></p>
<p><input type="text" class="input-xlarge" placeholder="Prix (Euro)" name="price"></p>
<p><input type="text" class="input-xlarge" placeholder="Prix (Dollar)" name="price2"></p>
<p><input type="text" class="input-xlarge" placeholder="TVA" name="tva"></p>
<p><input type="text" class="input-xlarge" placeholder="Bag in box" name="bag"></p>
<p><input type="text" class="input-xlarge" placeholder="Volume" name="volume"></p>

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
    	<p><input type="text" class="input-xlarge" placeholder="Label" name="{{$current->lang}}[label]"></p>
    	<p>Description <br> <textarea name="{{$current->lang}}[description]"></textarea></p>
	</div>
@endif


@foreach($languages as $lang)
  <div class="tab-pane fade" id="{{$lang->lang}}">
  	<p><input type="text" class="input-xlarge" placeholder="Label" name="{{$lang->lang}}[label]"></p>
    <p>Description <br> <textarea name="{{$lang->lang}}[description]"></textarea></p>
  </div>
@endforeach
</div>


<p><input type="submit" class="btn btn-inverse" value="Ajouter"> <input type="reset" class="btn" value="Annuler"></p>

{{Form::close()}}

@endsection


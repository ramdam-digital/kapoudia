@layout('layouts.admin')


@section('content')
<h3>Modifier un produit</h3>


<div class="info">

{{Form::open(URL::to_route('update_product'), 'PUT')}}

<p id="imgs">
  @foreach($images as $i)
  <img src="{{Ramdam::getUploadDir()}}{{$i->path}}" class="img-polaroid" style="width: 64px; height: 64px;">
  <input type="hidden" class="img-path" name="imgs[]" value="{{$i->path}}">
  @endforeach
  <a class="btn" onclick="window.open('{{URL::base()}}/elfinder/elf.php?id=imgs')">+</a>
  <a class="btn btn-inverse" id="remove">-</a>
</p>

{{Form::hidden('id', $product->id)}}

<p>{{Form::select('category', $categories, $product->category)}} </p>
<p>{{Form::select('brand', $brands, $product->brand)}} </p>
<p>{{Form::select('status', array(1=>'Publiée', 0=>'Non publiée'), $product->status)}} </p>


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
      <p>Libellé <br><input type="text" class="input-xlarge" placeholder="Label" name="{{$current->lang}}[label]" value="{{$data[$current->lang]['label']}}"></p>
      <p>Description <br> <textarea name="{{$current->lang}}[description]">{{$data[$current->lang]['description']}}</textarea></p>
  </div>
@endif


@foreach($languages as $lang)
  <div class="tab-pane fade" id="{{$lang->lang}}">
    <p>Libellé <br><input type="text" class="input-xlarge" placeholder="Label" name="{{$lang->lang}}[label]" value="{{$data[$lang->lang]['label']}}"></p>
    <p>Description <br> <textarea name="{{$lang->lang}}[description]">{{$data[$lang->lang]['description']}}</textarea></p>
  </div>
@endforeach
</div>

<hr>



<p>Référence <br><input type="text" class="input-xlarge" placeholder="Référence" name="reference" value="{{$product->reference}}"></p>
<p>Stock <br><input type="text" class="input-xlarge" placeholder="Stock" name="stock" value="{{$product->stock}}"></p>
<p>Prix (Euro) <br><input type="text" class="input-xlarge" placeholder="Prix" name="price" value="{{$product->price}}"></p>
<p>Prix (Dollar)<br><input type="text" class="input-xlarge" placeholder="Prix" name="price2" value="{{$product->price2}}"></p>
<p>TVA <br><input type="text" class="input-xlarge" placeholder="TVA" name="tva" value="{{$product->tva}}"></p>
<p>Bag in Box <br><input type="text" class="input-xlarge" placeholder="Bag in Box" name="bag" value="{{$product->bag}}"></p>
<p>Volume<br><input type="text" class="input-xlarge" placeholder="Prix" name="volume" value="{{$product->volume}}"></p>

<p><input type="submit" class="btn btn-inverse" value="Enregistrer"> <input type="reset" class="btn" value="Annuler"></p>
{{Form::close()}}

</div>




@endsection

@section('scripts')
<script type="text/javascript">
$(document).ready(function() {

    $('#remove').click(function(){
      $('.img-polaroid:first').remove();
      $('.img-path:first').remove();
    });

});
</script>
@endsection



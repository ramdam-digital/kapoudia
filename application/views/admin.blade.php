@layout('layouts.admin')
@section('content')

{{Form::open(URL::to_route('update_slider'), 'PUT')}}
<div><h3>Gestion des Sliders</h3></div>
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
    <p id="imgs{{$current->lang}}">
      @foreach($slides[$current->lang] as $i)
      <img src="{{Ramdam::getUploadDir()}}{{$i->path}}" class="img-polaroid" style="width: 64px; height: 64px;">
      <input type="hidden" class="img-path" name="imgs[{{$current->lang}}][]" value="{{$i->path}}">
      @endforeach
      <a class="btn" onclick="window.open('{{URL::base()}}/elfinder/elf.php?id=imgs{{$current->lang}}&lang={{$current->lang}}')">+</a>
      <a class="btn btn-inverse" id="remove{{$current->lang}}">-</a>
    </p>
</div>
@endif


@foreach($languages as $lang)
  <div class="tab-pane fade" id="{{$lang->lang}}">
    <p id="imgs{{$lang->lang}}">
      @foreach($slides[$lang->lang] as $i)
      <img src="{{Ramdam::getUploadDir()}}{{$i->path}}" class="img-polaroid" style="width: 64px; height: 64px;">
      <input type="hidden" class="img-path" name="imgs[{{$lang->lang}}][]" value="{{$i->path}}">
      @endforeach
      <a class="btn" onclick="window.open('{{URL::base()}}/elfinder/elf.php?id=imgs{{$lang->lang}}&lang={{$lang->lang}}')">+</a>
      <a class="btn btn-inverse" id="remove{{$lang->lang}}">-</a>
    </p>
  </div>
@endforeach
</div>
<p><input type="submit" class="btn btn-inverse" value="Appliquer"></p>
{{Form::close()}}


<div><h3>Socials</h3></div>
<div>
  {{Form::open(URL::to_route('update_socials'), 'PUT')}}
  @foreach($socials as $k=>$s)
  <p><label>{{ucfirst($k)}} </label><input type="text" class="input-xxlarge" name="socials[{{$k}}]" value="{{$s}}" ></p>
  @endforeach
  <p><input type="submit" class="btn btn-inverse" value="Appliquer"></p>
  {{Form::close()}}  
</div>



@endsection



@section('scripts')
<script type="text/javascript">
$(document).ready(function() {
    
    @if($current)

    $('#remove{{$current->lang}}').click(function(){
      $('#imgs{{$current->lang}} .img-polaroid:first').remove();
      $('#imgs{{$current->lang}} .img-path:first').remove();
    });

    @endif

    @foreach($languages as $lang)
    $('#remove{{$lang->lang}}').click(function(){
      $('#imgs{{$lang->lang}} .img-polaroid:first').remove();
      $('#imgs{{$lang->lang}} .img-path:first').remove();
    });
    @endforeach

});

</script>
@endsection

@layout('layouts.admin')

@section('headers')
<link href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css">

<script type="text/javascript">
  
function elFinderBrowser (field_name, url, type, win) {
    var elfinder_url = '{{URL::base()}}/elfinder/elfinder.html';    // use an absolute path!
    tinyMCE.activeEditor.windowManager.open({
      file: elfinder_url,
      title: 'elFinder 2.0',
      width: 900,  
      height: 450,
      resizable: 'yes',
      inline: 'yes',    // This parameter only has an effect if you use the inlinepopups plugin!
      popup_css: false, // Disable TinyMCE's default popup CSS
      close_previous: 'no'
    }, {
      window: win,
      input: field_name
    });
    return false;
  }

</script>

{{ HTML::script('tinymce/jscripts/tiny_mce/tiny_mce.js') }}
    <script type="text/javascript">
    tinyMCE.init({
            mode : "textareas",
            width : "545",
            height : "300",
            relative_urls : false,
            file_browser_callback : 'elFinderBrowser'
    });

    
    </script>
@endsection

@section('content')
<h3>Modifier une page</h3>

{{Form::open(URL::to_route('update_event'), 'PUT')}}
{{Form::hidden('id', $event->id)}}
<p>
{{Form::select('category', $categories, $event->category)}} 
{{Form::select('status', array(1=>'Publiée', 0=>'Non publiée'), $event->status)}} 
</p>

<p>
<img src="{{URL::base()}}/backend/img/calendar.png" style="padding-bottom:12px" > 
<input type="text" id="datepicker" name="date">
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

  <p id="imgs{{$current->lang}}">
      @foreach($images[$current->lang] as $i)
      <img src="{{Ramdam::getUploadDir()}}{{$i->path}}" class="img-polaroid" style="width: 64px; height: 64px;">
      <input type="hidden" class="img-path" name="imgs[{{$current->lang}}][]" value="{{$i->path}}">
      @endforeach
      <a class="btn" onclick="window.open('{{URL::base()}}/elfinder/elf.php?id=imgs{{$current->lang}}&lang={{$current->lang}}')">+</a>
      <a class="btn btn-inverse" id="remove{{$current->lang}}">-</a>
    </p>

		<p><input type="text" class="input-xxlarge" placeholder="Titre" name="{{$current->lang}}[title]" value="{{$data[$current->lang]['title']}}"></p>
		<p>Description<br><textarea name="{{$current->lang}}[description]">{{$data[$current->lang]['description']}}</textarea></p>
		<p>Contenu<br><textarea name="{{$current->lang}}[content]">{{$data[$current->lang]['content']}}</textarea></p>
	</div>
@endif


@foreach($languages as $lang)
  <div class="tab-pane fade" id="{{$lang->lang}}">

    <p id="imgs{{$lang->lang}}">
      @foreach($images[$lang->lang] as $i)
      <img src="{{Ramdam::getUploadDir()}}{{$i->path}}" class="img-polaroid" style="width: 64px; height: 64px;">
      <input type="hidden" class="img-path" name="imgs[{{$lang->lang}}][]" value="{{$i->path}}">
      @endforeach
      <a class="btn" onclick="window.open('{{URL::base()}}/elfinder/elf.php?id=imgs{{$lang->lang}}&lang={{$lang->lang}}')">+</a>
      <a class="btn btn-inverse" id="remove{{$lang->lang}}">-</a>
    </p>


	<p><input type="text" class="input-xxlarge" placeholder="Titre" name="{{$lang->lang}}[title]"  value="{{$data[$lang->lang]['title']}}"></p>
	<p>Description<br><textarea name="{{$lang->lang}}[description]">{{$data[$lang->lang]['description']}}</textarea></p>
	<p>Contenu<br><textarea name="{{$lang->lang}}[content]">{{$data[$lang->lang]['content']}}</textarea></p>
  </div>
@endforeach
</div>

<p><input type="submit" class="btn btn-inverse" value="Modifier"> <input type="reset" class="btn" value="Annuler"></p>

{{Form::close()}}

@endsection



@section('scripts')
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<script>

$(document).ready(function(){
   
    $( "#datepicker" ).datepicker();
    $( "#datepicker" ).datepicker("option", "dateFormat", "yy-mm-dd");
    $( "#datepicker" ).datepicker( "setDate" , "{{$date}}");
    
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
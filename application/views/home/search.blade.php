@layout('layouts.site')

@section('styles')
<link href="{{URL::base()}}/css/search.css" rel="stylesheet" type="text/css">
@endsection

@section('content')
<div id="white-head"></div>
<div id="white">
<div id="textContainer">
   <h1>Recherche :</h1>

    @if(Session::has('erreur'))
    <p class="msg-error">{{ Session::get('erreur') }}</p>
    @endif
    
  {{ Form::open(URL::to_route('search_result'), 'POST') }}

       <p><input type="text" name="keyword" placeholder="{{Lang::line('kapoudia.search_keyword')->get()}}" />
       <input type="submit" value=" " /></p>
       <p>
          <div class="cb sep"><input type="checkbox" name="pages" checked><label>Page</label></div>
          <div class="cb sep"><input type="checkbox" name="news" checked><label>{{Lang::line('kapoudia.news')->get()}}</label></div>
          <div class="cb"><input type="checkbox" name="products" checked><label>{{Lang::line('kapoudia.produit')->get()}}</label></div>
          <div class="clear"></div>
        </p>

  </form>

@if(isset($pages))
@foreach($pages as $p)
<div class="searchElement">
        <h2>{{$p['label']}}</h2>
        <p>
        {{$p['description']}} 
        </p>
        <a href="{{$p['link']}}">&raquo; {{Lang::line('kapoudia.savoir_plus')->get()}}</a>
        <hr>
</div>
@endforeach
@endif


@if(isset($events))
@foreach($events as $p)
<div class="searchElement">
        <h2>{{$p['label']}}</h2>
        <p>
        {{$p['description']}} 
        </p>
        <a href="{{$p['link']}}">&raquo; {{Lang::line('kapoudia.savoir_plus')->get()}}</a>
        <hr>
</div>
@endforeach
@endif


@if(isset($products))
@foreach($products as $p)
<div class="searchElement">
        <h2>{{$p['label']}}</h2>
        <p>
        {{$p['description']}} 
        </p>
        <a href="{{$p['link']}}">&raquo; {{Lang::line('kapoudia.savoir_plus')->get()}}</a>
        <hr>
</div>
@endforeach
@endif

</div>
    <div class="clear" style="height:200px;"></div>

</div>
@endsection
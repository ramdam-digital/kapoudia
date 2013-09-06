@layout('layouts.site')

@section('styles')
<link href="{{URL::base()}}/css/scroll.css" rel="stylesheet" type="text/css">
<link href="{{URL::base()}}/css/production.css" rel="stylesheet" type="text/css">
@endsection

@section('content')


<div id="wood-head"></div>
<div id="wood">

<div id="production">
    <h1>{{$page->title}}</h1>
    <p class="description">{{$page->description}}</p>
<div id="blocs">
    {{$page->content}}
    <div class="clear"></div>
</div>
</div>

</div>
@endsection





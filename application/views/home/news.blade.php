@layout('layouts.site')

@section('styles')
<link href="{{URL::base()}}/css/neuf.css" rel="stylesheet" type="text/css">
@endsection

@section('content')
<div id="white-head"></div>
<div id="white">
   <h1>{{$title}}</h1>

    @foreach($news as $n)
    <div class="article">

        @if(isset($n->image) && !empty($n->image))
            <img src="{{URL::base()}}/resizer?path={{Ramdam::getUploadDir()}}{{$n->image}}&w=230">
        @endif
        <div>
            <h3>{{$n->title}}</h3>
            <p class="date">{{$n->calendar}}</p>
            {{$n->content}}
        </div>
    </div>
    @endforeach



    <div class="clear" style="height:200px;"></div>
</div>
@endsection

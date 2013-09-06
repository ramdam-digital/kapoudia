@layout('layouts.site')

@section('styles')
<link href="{{URL::base()}}/css/ethique.css" rel="stylesheet" type="text/css">
@endsection

@section('content')
<div id="wood-head"></div>
<div id="wood">

<div id="limiter">
    
    {{$page->content}}

    <div class="clear"></div>
</div>

</div>
@endsection

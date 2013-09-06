<nav>

<?php 
$lang = Config::get('application.language');
$menu = Menu::allByCategory(0, $lang);
if(!isset($current)) $current = array();
?>
<ul>
@foreach($menu as $m)
<?php 
$link = (!empty($m->method) && $m->method != 'none') ? URL::to_route('to_menu', array(Ramdam::getSlug($m->label), $m->id)): '#';
$sub = Menu::allByCategory($m->id, $lang);
$cur = (in_array($m->id , $current)) ? 'class = "current"': '';
?>
<li {{$cur}}><a href="{{$link}}" {{$cur}}>{{$m->label}}</a>

@if(count($sub)>0)
    <ul class="submenu">
        @foreach($sub as $s)
        <?php 
        $link = (!empty($s->method) && $s->method != 'none') ? URL::to_route('to_menu', array(Ramdam::getSlug($s->label), $s->id)): '#';
        $cur = (in_array($s->id , $current)) ? 'class = "current"': '';
        ?>
        <li><a href="{{$link}}" {{$cur}}>{{$s->label}}</a></li>
        @endforeach
    </ul>
@endif

</li>
@endforeach
</ul>

<select id="reponsiveMenu">
    @foreach($menu as $m)
    <?php 
    $sub = Menu::allByCategory($m->id, $lang);
    ?>
    <optgroup label="{{$m->label}}">
        @foreach($sub as $s)
        <?php
        $link = (!empty($s->method) && $s->method != 'none') ? URL::to_route('to_menu', array(Ramdam::getSlug($s->label), $s->id)): '#';
        $cur = (in_array($s->id , $current)) ? 'selected="selected"': '';
        ?>
        <option value="{{$link}}" {{$cur}}>{{$s->label}}</option>
        @endforeach
    </optgroup>
    @endforeach
</select>

</nav>
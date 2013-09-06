<?php
$lang = Config::get('application.language');
$menu = Menu::allByCategory(0, $lang); 
?>
<table class="tab">
                <thead>
                    <tr>
                        @foreach($menu as $m)
                        <th>{{$m->label}}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        @foreach($menu as $m)
                        <?php $sub = Menu::allByCategory($m->id, $lang); ?>
                        <td>
                            @if(count($sub)>0)
                            <ul>
                                @foreach($sub as $s)
                                <?php 
                                $link = (!empty($s->method) && $s->method != 'none') ? URL::to_route('to_menu', array(Ramdam::getSlug($s->label), $s->id)): '#';
                                ?>
                                <li><a href="{{$link}}">{{$s->label}}</a></li>
                                @endforeach
                            </ul>
                            @endif
                        </td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
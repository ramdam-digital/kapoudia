<footer>
<div id="footer">
    <div id="container">
        <div class="left">
            @include('blocks.fmenu')
        </div>
        <div class="right">
            <table class="social">
                <thead>
                    <tr>
                        <th>Suivez nous</th>
                    </tr>
                </thead>
                    <tbody>
                        <tr>
                            <td>
                                <ul class="socials">
                                    <li><a href="{{Ramdam::getOption('facebook')}}" target="_blank"><img src="{{URL::base()}}/img/fb.png"  alt=" "> Facebook</a><div class="clear"></div></li>
                                    <li><a href="{{Ramdam::getOption('youtube')}}" target="_blank"><img src="{{URL::base()}}/img/yt.png"  alt=" "> Youtube</a><div class="clear"></div></li>
                                    <li><a href="{{Ramdam::getOption('blog')}}" target="_blank"><img src="{{URL::base()}}/img/blog.png"  alt=" "> Blog</a><div class="clear"></div></li>
                                </ul>
                            </td>
                        </tr>
                    </tbody>
                
            </table>
        </div>

    </div>
</div>

<div id="copyright">
    <div class="box">
        <div class="copy">2013 - Copyright &copy; Kapoudia</div>
        <div class="ramdam"><a href="http://www.ramdam.in" target="_blank"><img src="{{URL::base()}}/img/siteby.png"></a></div>
        <div class="clear"></div>
    </div>
</div>
</footer>
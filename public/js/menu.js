function menu(){
    
    $("nav ul li.current").find("ul.submenu").show();

    current = null;
    var menu = null;
    $('nav ul li').mouseover(function(){
        menu = $(this).find("ul.submenu");
        if(current != null && current != menu && current.parent().hasClass('current') == false) current.hide();
        menu.show();
        current = menu;
        menu.mouseout(function(){
            if($(this).parent().hasClass('current') == false){
                if(menu != null) menu.hide();
            }
        });
    });

    /*$('nav ul li').click(function(){
        if(menu != null) menu.hide();
    });*/

    navigation();
}

function navigation(){
    $("#reponsiveMenu").on("change", function(){
        window.location = this.value;
    });
}
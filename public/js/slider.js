function slider()
{
    var elements = $('#slides ul li').size();
    var width_ul = elements * 100;
    $('#slides ul').css('width', width_ul+"%");
    $('#slides ul li').css('width', (100/elements)+"%");

    var slide_speed = 300;
    
    var item_width = width_ul / elements;
    var left_value = item_width * (-1);

    $('#slides li:first').before($('#slides li:last'));
    
    $('#slides ul').css({'left' : left_value+'%'});

    $('#prev').click(function() {

        var left_indent = parseInt($('#slides ul').css('left'))/ parseInt($('#slides').css('width')) *100 + item_width;

        $('#slides ul').animate({'left' : left_indent+'%'}, slide_speed,function(){    

            $('#slides li:first').before($('#slides li:last'));

            $('#slides ul').css({'left' : left_value+'%'});
        
        });

        return false;
            
    });
 
    $('#next').click(function() {
        
        var left_indent = parseInt($('#slides ul').css('left'))/ parseInt($('#slides').css('width')) *100 - item_width;
        
        $('#slides ul').animate({'left' : left_indent+"%"}, slide_speed, function () {
            
            $('#slides li:last').after($('#slides li:first'));                  
            
            $('#slides ul').css({'left' : left_value+"%"});
        
        });
                 
        return false;
        
    });     

        
   setInterval(function(){
        var left_indent = parseInt($('#slides ul').css('left'))/ parseInt($('#slides').css('width')) *100 - item_width;
       
        $('#slides ul').animate({'left' : left_indent+"%"}, slide_speed, function () {
            
            $('#slides li:last').after($('#slides li:first'));                  
            
            $('#slides ul').css({'left' : left_value+"%"});
        
        });
                 
        return false;
    }
    , 5000); 


}


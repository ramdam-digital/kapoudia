function produits(){
	
	var elements = $("#productSlider li").size();
	var item_width = $('#productSlider li').outerWidth();
	$('#next').click(function(){
			$('#productSlider').animate({'left' : item_width},200,function(){    
		        //$('#productSlider li:last').before($('#productSlider li:first')); 
		        //$('#productSlider').css({'right' : item_width});
			});
	});

	$('#prev').click(function(){
			var item_width = $('#productSlider li').outerWidth();
			//alert(item_width);return;
			//$('#productSlider li:first').css('right', (-1 * elements * item_width));	        
	        $('#productSlider').animate({'right' : item_width},200,function(){    
		        //$('#productSlider li:last').before($('#productSlider li:first')); 
		        //$('#productSlider').css({'right' : item_width});
			});
    });
}

function slide_product(){
	var current_id = 1;

	$('#next').click(function(){
	    if(current_id >= $('#prix ul li').size()){
	        current_id = 1;
	    } else{
	        current_id++;
	    }
	    $('#prix ul li').each(function(){
	        $(this).hide();
	    });
	    $('#price'+current_id).show();

	    var cid = $('#id'+current_id).val();
	    cid = parseInt(cid);
	    $('#current_product').val(cid);

	    $('#thumb img').each(function(){
	        $(this).hide();
	    });
	    $('#img'+current_id).show();
	});

	$('#prev').click(function(){
	    if(current_id <= 1 ){
	        current_id = $('#prix ul li').size();
	    } else{
	        current_id--;
	    }
	    $('#prix ul li').each(function(){
	        $(this).hide();
	    });
	    $('#price'+current_id).show();
	    var cid = $('#id'+current_id).val();
	    cid = parseInt(cid);
	    $('#current_product').val(cid);

	    $('#thumb img').each(function(){
	        $(this).hide();
	    });
	    $('#img'+current_id).show();
	});

	$('#up_panier').click(function(){
	    var q = $("#quantite").val();
	    q = parseInt(q);
	    q++;
	    $("#quantite").val(q);
	});

	$('#down_panier').click(function(){
	    var q = $("#quantite").val();
	    q = parseInt(q);
	    if(q>0){
	        q--;
	    }else{
	        q = 0;
	    }
	    $("#quantite").val(q);
	});

}


function add_panier(base){
	$('#add_panier').click(function(){

	    event.preventDefault();
	    var id_product = $('#current_product').val();
	    id_product = parseInt(id_product);
	    var quantite = $('#quantite').val();
	    quantite = parseInt(quantite);

	    if(quantite>0){
			$.ajax({
			  url: base+'add_cart',
			  data: { quantite: quantite, product: id_product }
			}).done(function(data){
				$("#quantite").val(0);
				$('#panier-msg').slideDown().delay(3000).slideUp();
			});
		}

	});
}
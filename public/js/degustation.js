function degustation(){
	$('#ctn1-3').css('display', 'none');
	$('#ctn1-2').css('display', 'none');

	$('#ctn2-3').css('display', 'none');
	$('#ctn2-2').css('display', 'none');

	$('#ctn3-2').css('display', 'none');
	$('#ctn3-3').css('display', 'none');
	$('#ctn3-4').css('display', 'none');
	$('#ctn3-5').css('display', 'none');

	$('#fruite').click(function(){
		$('#ctn1-2').hide();
		$('#ctn1-1').show();
		$('#ctn1-3').hide();
	});

	$('#piquant').click(function(){
		$('#ctn1-2').hide();
		$('#ctn1-1').hide();
		$('#ctn1-3').show();
	});

	$('#amer').click(function(){
		$('#ctn1-2').show();
		$('#ctn1-1').hide();
		$('#ctn1-3').hide();
	});

	$('#chome').click(function(){
		$('#ctn2-1').show();
		$('#ctn2-2').hide();
		$('#ctn2-3').hide();
	});

	$('#moisissure').click(function(){
		$('#ctn2-1').hide();
		$('#ctn2-2').show();
		$('#ctn2-3').hide();
	});

	$('#vineux').click(function(){
		$('#ctn2-1').hide();
		$('#ctn2-2').hide();
		$('#ctn2-3').show();
	});

	$('#tasting').click(function(){
		$('#ctn3-1').show();
		$('#ctn3-2').hide();
		$('#ctn3-3').hide();
		$('#ctn3-4').hide();
		$('#ctn3-5').hide();
	});

	$('#coup').click(function(){
		$('#ctn3-1').hide();
		$('#ctn3-2').show();
		$('#ctn3-3').hide();
		$('#ctn3-4').hide();
		$('#ctn3-5').hide();
	});

	$('#temperature').click(function(){
		$('#ctn3-1').hide();
		$('#ctn3-2').hide();
		$('#ctn3-3').show();
		$('#ctn3-4').hide();
		$('#ctn3-5').hide();
	});

	$('#digest').click(function(){
		$('#ctn3-1').hide();
		$('#ctn3-2').hide();
		$('#ctn3-3').hide();
		$('#ctn3-4').show();
		$('#ctn3-5').hide();
	});

	$('#classification').click(function(){
		$('#ctn3-1').hide();
		$('#ctn3-2').hide();
		$('#ctn3-3').hide();
		$('#ctn3-4').hide();
		$('#ctn3-5').show();
	});
}
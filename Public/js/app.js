(function($)
{
	var url = window.location.pathname;

	//Automatic active class for nav and menus
	$('section ul li a').each(function ()
	{
		checkString = url.match($(this).attr('href'));
		if ((checkString !== null && $(this).attr('href') !== '/') || (url == $(this).attr('href')))
		{ $(this).parent('li').addClass('active'); }
	});
	
})(jQuery);
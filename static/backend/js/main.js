$(function(){
	(function(){
		var addEvent = (function(){
		if (window.addEventListener)
		{
			return function(el, sType, fn, capture) {
			el.addEventListener(sType, fn, (capture));
			};
		}
		else if (window.attachEvent)
		{
			return function(el, sType, fn, capture) {
			el.attachEvent("on" + sType, fn);
			};
		}
		else
		{
			return function(){};
		}
		})();

	    var Scroll = document.getElementById('menu_box');
	    var obj_Scroll = $('#menu');
	    // IE6/IE7/IE8/Opera 10+/Safari5+
	    addEvent(Scroll, 'mousewheel', function(event){
	        event = window.event || event ;
	        Scroll_top(event,obj_Scroll);
	    }, false);

	    // Firefox 3.5+
	    addEvent(Scroll, 'DOMMouseScroll',  function(event){
	        event = window.event || event ;
	        Scroll_top(event,obj_Scroll);
	    }, false);

	})();

	if(localStorage.column_Cls == 'active')
	{
		$('#column-left').addClass('active');
		$('#button-menu').find('i').removeClass('fa-indent').addClass('fa-dedent');
	}
	else
	{
		
	}	
	
	$('#button-menu').click(function(){
	    if($(this).find('i').hasClass('fa-dedent'))
	    {
	    	localStorage.column_Cls = '';
	        $(this).find('i').removeClass('fa-dedent').addClass('fa-indent');
	        $('#column-left').removeClass('active');
	    }
	    else
	    {
	    	localStorage.column_Cls = 'active';
	        $(this).find('i').removeClass('fa-indent').addClass('fa-dedent');
	        $('#column-left').addClass('active');
	        $('.first_ul').slideUp(1);
	        $('#menu>li:first>ul:first').slideDown(1);
	        $('#menu>li:first>a:first').find('c').removeClass('fa-angle-up').addClass('fa-angle-down');
	    }
	})
	$('#menu>li:first>ul:first').slideDown(1);
	setTimeout('windowW()',500);
	$('#menu>li:first>a:first').find('c').removeClass('fa-angle-up').addClass('fa-angle-down');
	$('#menu>li>a').click(function(){
		if($(this).next('ul').is(':visible'))return false;
		$('.first_ul').slideUp(200);
		$('.first_ul').prev('a').find('c').removeClass('fa-angle-down').addClass('fa-angle-up');
		$(this).next('ul').slideDown(200);
		$(this).find('c').removeClass('fa-angle-up').addClass('fa-angle-down');
		setTimeout('windowW()',500);
	})
	$('#menu>li>a').hover(function(){
		if(!$('#column-left').hasClass('active'))$(this).next('ul').show();
	},function(){

	})
	$(window).on('resize', function(){
	    windowW();
        iframe_height();
	});
    iframe_height();
    $('#reload').click(function(){
        try
        {
            $('#rightMain').contents().find("._ajaxLoading").show();
            document.getElementById('rightMain').contentWindow.location.reload(true);
        }
        catch(err)
        {

        }
    });
    $('a').click(function(){
        var href = $(this).attr('data-href');
        if(href)
        {
            $('a').removeClass('on');
            $(this).addClass('on');
            $(this).parent('li').parent('ul').prev('a').addClass('on');
            $(this).parent('li').parent('ul').parent('li').parent('ul').prev('a').addClass('on');
            $("#rightMain").attr('src', href);
            var breadcrumb = $(this).attr('data-breadcrumb');
                breadcrumb = breadcrumb ? '<i class="fa fa-location-arrow fa-lg"></i>&nbsp;&nbsp;'+breadcrumb : '';
                $('.lbreadcrumb a').html(breadcrumb);
        }

    })
})

function iframe_height()
{
    $('#rightMain').height($('body').height() - 45);
}

function menuScroll(num)
{
	var obj_Scroll = $('#menu');
	if(num==2)
	{
		var h = (obj_Scroll.position().top+40);
		h = h >=0 ? 0 :h;
	}
	else
	{
		var h  = (obj_Scroll.position().top-40);
		var wh = obj_Scroll.height();
		var bh = $('body').height() - 87;
		if(bh >= wh)return false;
		wh = bh - wh;
		var temp = $('#column-left').hasClass('active') ? 50 : 16;
		h  = h <= wh  ? wh - temp :h;
	}
	obj_Scroll.css({'top':h+'px'});
}

function Scroll_top(event,obj_Scroll)
{
    var h = (obj_Scroll.position().top-40);
    if(event.wheelDelta <= 0 || event.detail > 0)
    {
		var wh = obj_Scroll.height();
		var bh = $('body').height() - 87;
		if(bh >= wh)return false;
		wh = bh - wh;
		var temp = $('#column-left').hasClass('active') ? 50 : 16;
		h  = h <= wh  ? wh - temp :h;
    }
    else
    {
		h = h <=0 ? 0 :h;
    }
    obj_Scroll.css({'top':h+'px'});
}

function windowW()
{
    if(($('body').height()-136) <= $('#menu').height())
    {
        $(".scroll").show();
    }
    else
    {
        $(".scroll").hide();
    }
}



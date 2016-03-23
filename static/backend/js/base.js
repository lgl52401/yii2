function _ajax_data($form,$btn)
{
	var style = $btn.attr('data-style');
	var msg   = $form.find('.formMsg:first').length;
	var tun   = 0;
	$.ajax({
		type: 'POST',
		url : $form.attr('action'),
		async: false,
		data: $form.serialize(),
		dataType:'json',
		success:function(ret){
			if(ret.success)
			{
				tun = ret.data ? ret.data : -1;
				if(msg)$form.find('.formMsg:first').html('<div class="alert alert-success alert-dismissible" ><button class="close" type="button" ><i class="fa fa-check"></i></button><strong>'+ret.msg+'</strong></div>');
                if($btn.attr('data-refresh'))window.location.reload(true);
			}
			else
			{
				var verifycode = $form.find('.verifycode:first');
				if(verifycode.length)verifycode.click();
				if(msg)
				{
					if(msg)$form.find('.formMsg:first').html('<div class="alert alert-danger alert-dismissible" ><button class="close" type="button" ><i class="fa fa-close"></i></button><strong>'+ret.msg+'</strong></div>');
				}
				else
				{
					$.dialog.alert({'msg':ret.msg});
				}
			}
		},
		error:function(){
			$.dialog.alert({'msg':js_lang.server_data_error});
			$('._ajaxData').hide();
		}
	});
	return tun;
}

function ajax_submit(form,$btn)
{	
	$cache_id = 'form_'+form.attr('id');
	if(form.data($cache_id))return false;
	form.data($cache_id, 'yes');
	form.on('beforeSubmit',function(e){
		var $form = $(this);
		var temp  = $btn.html();
		var btn_i = $btn.find('i').clone();$btn.find('i').remove();
		$btn.attr('disabled','disabled').append('<i class="fa fa-spinner fa-spin fa-1x"></i>');
		_ajax_data($form,$btn);
		$btn.removeAttr('disabled','disabled').html(temp);
	}).on('submit',function(e){
		e.preventDefault();
	});
}

$(function(){
	$(document).on('click','._save',function(event){
		var form = jQuery('form#'+$(this).attr('data-option'));
		var $btn = $(this);
		if (form.find('.has-error').length)return false;
		ajax_submit(form,$btn);
	})
});

jQuery.dialog = {          
    alert:function(param,callback)
    {   
        param.type = 1;
        $.dialog.init(param,callback);
    },          
    confirm:function(param,callback)
    {          
        param.type = 2;
        $.dialog.init(param,callback);
    },
    prompt:function(param,callback)
    {          
        param.type = 3;
        $.dialog.init(param,callback);
    },
    loading:function(param,callback)
    {          
        param.type = 4;
        $.dialog.init(param,callback);
    },
    actions:function(param,callback)
    {          
        var defaults = {msg:'标题',content:'-'};
             options = $.extend(defaults,param);
             obj     = $('#'+options.obj.attr('data-id'));
             if(!obj.length)
             {
                $.dialog.dark({'msg':'缺少对象'});
                return false;
             }
        var str  = '';
            str += '<div class="modal-actions">';
            str += '<div class="modal-actions-group">';
            str += obj.html();
            str += '</div>';
            str += '<div class="modal-actions-group">';
            str += '<button class="button-secondary pure-button button-block modal-actions-cancel">取消</button>';
            str += '</div>';
            str += '</div>';
        var overlay = $("<div id='lean_overlay' class='ui-mask'></div>");
        if(!document.getElementById('lean_overlay')){$('body').append(overlay);}
        $('#lean_overlay').fadeIn(200);
        $('body').append(str);
        $('.modal-actions .list').css({'max-height':$('body').height()/2});
        $('.modal-actions').animate({height: 'toggle'}, 500);
        $('.modal-actions-cancel').click(function(){
            $('#lean_overlay').fadeOut();
            $('.modal-actions').slideUp(500,function(){$('.modal-actions').remove();});
        })
    },
    dark:function(param,callback)
    {
        var defaults  = {msg:'标题',time:'3'};
             options  = $.extend(defaults,param);
             var str  = '<div class="modal-dark">';
                 str += '<p>';
                 str += options.msg;
                 str += '</p>';
                 str += '</div>';
        function inters()
        {
            $('.modal-dark').fadeOut('slow',function(){$('.modal-dark').remove();});
            clearTimeout(window.clear_interrs);
        }
        if(window.clear_interrs) clearTimeout(window.clear_interrs);
        $('.modal-dark').remove();
        $('body').append(str);
        w = $('.modal-dark').outerWidth() / 2;
        h = $('.modal-dark').outerHeight() / 2;
        $('.modal-dark').css({'margin-left': '-'+w+'px','margin-top': '-'+h+'px'});
        $('.modal-dark').fadeIn('slow');
        if(options.time)
        {
            window.clear_interrs = setTimeout(inters,options.time * 1000);
        }
    },
    popup:function(param,callback)
    {
        var defaults = {msg:'标题',obj:''};
             options = $.extend(defaults,param);
             obj     = $('#'+options.obj.attr('data-id'));
             if(!obj.length)
             {
                $.dialog.dark({'msg':'缺少对象'});
                return false;
             }
        var str  = '<div class="modal-popup">';
            str += '<div class="popup-inner">';
            str += '<div class="popup-header">';
            str += '<h4 class="popup-title">'+options.msg+'</h4>';
            str += '<i class="fa fa-close popup-close"></i>';
            str += '</div>';
            str += '<div class="popup-body">';
            str += obj.html();
            str += '</div>';
            str += '</div>';
            str += '</div>';
        $('.modal-popup').remove();
        $('body').append(str);
        $('.popup-close').click(function(){
            h = $('.modal-popup').height();
            $('.modal-popup').animate({top: h+'px'}, 400,function(){$('.modal-popup').remove();});
        })
        $('.modal-popup').animate({top: '0px'}, 400);    
    },
    notifi:function(param,callback)
    {   
        var defaults = {msg:'-',info:'系统提示',time:'5'};
             options = $.extend(defaults,param);     
        var str  = '<div class="notification" style="display:none">';
            str += '<div class="notification-content">';
            str += '<h3 class="notification-title"><i class="fa fa-commenting-o fa-yellow"></i> '+options.info+'</h3>';
            str += '<span>'+options.msg+'</span>';
            str += '</div>';
            str += '<i class="fa fa-close notification-close"></i>';
            str += '</div>';
        function ints()
        {
            $('.notification').animate({height: 'toggle', opacity: 'toggle'}, 200,function(){$('.notification').remove();});
            clearTimeout(window.clear_ints);
        }
        if(window.clear_ints) clearTimeout(window.clear_ints);
        $('.notification').remove();
        $('body').append(str);
        $('.notification').animate({height: 'toggle', opacity: 'toggle'}, 200);

        if(options.time)
        {
            window.clear_ints = setTimeout(ints,options.time * 1000);
        }

        $('.notification-close').click(function(){
            ints();
        })
    },
    init:function(options,callback)
    {
        var defaults = {msg:'-',closeButton:null,info:'系统提示',placeholder:'','close':''};
             options = $.extend(defaults,options);
             style   = '';
        if(options.type == 4) style = 'style="border:0px"';
        var str  = '<div class="ui-dialog" >';
            str += '<div class="ui-dialog-title">';
            if(options.close)
            {
                str += '<a class="ui-dialog-close">';
                str += '<i class="fa fa-close fa-lg"></i>';
                str += '</a>';
            }
            str += '<h3>'+options.info+'</h3>';
            str += '</div>';
            str += '<div class="ui-dialog-content" '+style+'>';
            str += '<div class="vote-dialog" >';
            if(options.type == 4)
            {
                str += '<div class="loader-bounce1"></div><div class="loader-bounce2"></div><div ></div>';
            }
            else
            {
                str += '<p>'+options.msg+'</p>';
            }

            if(options.type == 3)
            {
                str += '<input class="prompt-input" type="text" placeholder="'+options.placeholder+'">';
            }
            str += '</div>';
            str += '</div>';
            str += '<div class="ui-dialog-btns" >';
            if(options.type == 2 || options.type == 3)
            {
                str += '<a class="ui-btn ui-btn-1">取消</a>';
            }
            if(options.type != 4) str += '<a class="ui-btn ui-btn-2">确定</a>';
            str += '</div>';
            str += '</div>'; 
        $('.ui-dialog').remove();
        var overlay = $("<div id='lean_overlay' class='ui-mask'></div>");
        if(!document.getElementById('lean_overlay')){$('body').append(overlay);}
        $('body').append(str);
        if(options.type == 4)
        {
            $('#lean_overlay').fadeIn(1);$('.ui-dialog').fadeIn(1);
        }
        else
        {
            $('#lean_overlay').fadeIn(200);$('.ui-dialog').fadeIn('fast');
        }    
        $('.ui-btn-2,.ui-btn-1,.ui-dialog-close').click(function(){
            $('.ui-dialog').fadeOut('fast',function(){$('.ui-dialog').remove();$('#lean_overlay').fadeOut();});
            if(options.type == 4)return false;
            if(options.type == 2 && $(this).hasClass('ui-btn-2'))
            {
                if(callback)callback();
            }
            else if(options.type == 3 && $(this).hasClass('ui-btn-2'))
            {
                val = $.trim($('.ui-dialog .prompt-input:first').val());
                if(val && callback)
                {
                    callback(val);
                }
            }
            return false;
        })
    }
};
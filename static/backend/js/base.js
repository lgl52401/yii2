function _try_return(data)
{ 
    try
    {
        var datas = eval('(' + data + ')');  // change the JSON string to javascript object   
        return datas;
    }
    catch (e)
    {
        return false;
    } 
}

function _ajax_data($form,$btn)
{
	var style    = $btn.attr('data-style');
	var $formMsg = $form.find('.formMsg:first');
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
				if($formMsg.length)
                {
                    $formMsg.html('<div class="alert alert-success"> <i class="fa fa-check-circle"></i> <strong>'+ret.msg+'</strong><button type="button" data-dismiss="alert" class="close">×</button></div>');
                    $formMsg.find('.alert').fadeIn();
                }
                if($btn.attr('data-refresh'))window.location.reload(true);
			}
			else
			{
				var verifycode = $form.find('.verifycode:first');
				if(verifycode.length)verifycode.click();
				if($formMsg.length)
				{
					$formMsg.html('<div class="alert alert-danger"> <i class="fa fa-exclamation-circle"></i> <strong>'+ret.msg+'</strong><button type="button" data-dismiss="alert" class="close">×</button></div>');
                    $formMsg.find('.alert').fadeIn();
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

function _ajax_html(url,temp,div_id)
{
    $('#'+div_id).remove();
    $('.modal-backdrop').remove();
    $('.ajax-loading').show();
    if(!$('#'+div_id).length)
    {
        var tun = 0;
        $.ajax({
        type: 'POST',
        url : url,
        async: false,
        data: temp,
        success: function (json)
        {
            var i = json.indexOf('{"success":false,"msg":') 
            if(i >= 0)
            {
                ta = _try_return(json);      
                $.dialog.alert(ta.msg);
                tun = 0;
            }
            else
            {
                $('body').append(json);
                tun = 1;
            } 
        },
       error: function () {
            $.dialog.alert('系统错误');
        }
        });
        $obj = $('#getModal .modal-dialog');
        $obj.css({'margin-left':'-'+$obj.width()/2+'px','margin-top':'-'+$obj.height()/2+'px'});
        $('.ajax-loading').hide();
        return tun;
    }
    $('.ajax-loading').hide();
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
    $('body').append('<div class="ajax-loading"><div><p></p></div></div><div class="_ajaxData"></div><a id="_hiddenBtn" style="display:none" class="btn btn-primary"  data-backdrop="static"  data-target="#getModal" data-toggle="modal" ></a>');

    /*
        动态提交数据
    */
	$(document).on('click','._save',function(event){
		var form = jQuery('form#'+$(this).attr('data-option'));
		var $btn = $(this);
		if (form.find('.has-error').length)return false;
		ajax_submit(form,$btn);
	})

    /*
        动态加载数据
    */
    $(document).on('click','._loadModel',function(event){
        var url     = $(this).attr('data-url');
        var parame  = $(this).attr('data-parame');
            parame  = parame ? parame : '';
        if(!url)
        {
            $.dialog.alert({'msg':'url丢失'});
            return false;
        }
        ret = _ajax_html(url,parame,'getModal');
        if(ret)
        {
            $.dragInit({trigger:'.modal-content',handle:'#_modal-header'});
            setTimeout(function(){$('#_hiddenBtn').click();},20)
        }
    })
    /*
        关闭弹出框
    */
    $(document).on('click','._closeModel',function(){
        if($(this).attr('data-reload'))
        {
            window.location.reload();
        }
        else
        {
            $('#_hiddenBtn').click();
            setTimeout(function(){$('#getModal').remove();
            $('.modal-backdrop').remove();},500);
        }
    }) 
});
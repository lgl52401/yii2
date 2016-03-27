function _try_return(data)
{ 
    try
    {
        var datas = eval('(' + data + ')');
        return datas;
    }
    catch (e)
    {
        return false;
    } 
}

/*
    计算页码
*/
function pageNum(exp1, exp2)
{  
    var n1 = Math.round(exp1); //四舍五入     
    var n2 = Math.round(exp2); //四舍五入    
    var rslt = n1 / n2; //除    
    if (rslt >= 0)
    {  
        rslt = Math.floor(rslt); //返回小于等于原rslt的最大整数。     
    }  
    else
    {  
        rslt = Math.ceil(rslt); //返回大于等于原rslt的最小整数。     
    }  
    return rslt;  
}

/*
    刷新数据列表
*/ 
function tableReload()
{
    if(oTable && !oTable.fnSettings().ajax)
    {   
        oTable.fnPageChange(pageNum(oTable.fnSettings()._iDisplayStart, oTable.fnSettings()._iDisplayLength));
    }
    else
    {
        if( 'undefined' != typeof reload)
        {
            location.reload();
        }
        else
        {
            oTable.api().ajax.reload();
        } 
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

                tableReload();
                
                if($btn.attr('data-refresh'))
                {
                    window.location.reload(true);
                }
                else if($btn.attr('data-close'))
                {
                    $('._closeModel').click();
                }
			}
			else
			{
				var verifycode = $form.find('.verifycode:first');
				if(verifycode.length)verifycode.click();
				if(!$formMsg.length)
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
			//$('.ajax-data').hide();
		}
	});
	return tun;
}

function _ajax_com_data(url,temp)
{
    var tun = 0;
    $.ajax({
       type: 'POST',
       url : url,
       async: false,
       data: temp,
       dataType:'json',
       success: function(ret)
       {
           if(ret.success)
           {
                if(ret.data)
                {
                    tun = ret.data;
                }
                else
                {
                    tun = -1;
                }    
           }
           else
           {
                setTimeout(function(){$.dialog.alert({'msg':ret.msg});;},500);
           }
       },
       error: function () {
            setTimeout(function(){$.dialog.alert({'msg':js_lang.server_data_error});},500);
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
                $.dialog.alert({'msg':ta.msg});
                tun = 0;
            }
            else
            {
                $('body').append('<div id="getModal" class="modal  fade" style="display:block">'+json+'</div>');
                tun = 1;
            } 
        },
       error: function () {
            $.dialog.alert({'msg':js_lang.server_data_error});
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
    $('body').append('<div class="ajax-loading"><div><p></p></div></div><a id="_hiddenBtn" style="display:none" class="btn btn-primary"  data-backdrop="static"  data-target="#getModal" data-toggle="modal" ></a>');

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
            $.dialog.alert({'msg':js_lang.missing_url});
            return false;
        }
        ret = _ajax_html(url,parame,'getModal');
        if(ret)
        {
            $.dragInit({trigger:'.modal-content',handle:'#_modal-header'});
            setTimeout(function(){$('#_hiddenBtn').click();},20);
        }
    })
    /*
        关闭弹出框
    */
    $(document).on('click','._closeModel',function(){
        if($(this).attr('data-refresh'))
        {
            window.location.reload();
        }
        else
        {
            $('#getModal').slideUp('fast',function(){setTimeout(function(){$('#getModal').remove();$('.modal-backdrop').remove();},1);});
        }
    })
    /*
        多选按钮
    */
    $('.checkAll').on('click',function(){
        is_check = $(this).prop('checked');
        $obj     = $(this).parents('.checkParent:first')
        if (is_check)
        {
            $obj.find("input[name='checkList']").prop('checked',is_check);
        } 
        else 
        {
            $obj.find("input[name='checkList']").prop('checked', false);
        }
    });

    /*
        单个删除操作
    */ 
    $(document).on('click','._del',function(){
        url = $(this).attr('data-url');
        ID  = $(this).attr('data-parame');
        if(!url)return false;
        $.dialog.confirm({'msg':js_lang.sure_do},function(){
            tmp = _ajax_com_data(url,ID);
            if(tmp == -1)
            {
                tableReload();
            }
            else
            {
                //call_back(tmp);
            }
        });
    });

    /*
        批量删除
    */
    $(document).on('click','.deleteFun',function(){
        url = $(this).attr('data-url');
        if(!url)
        {
            $.dialog.alert({'msg':js_lang.missing_parameters});
            return false;
        }
        var str = '';
           $obj = $(this).parents('.row-fluid:first').prev('.checkParent:first');
        $obj.find("input[name='checkList']:checked").each(function (i, o) {
            str += $(this).val();
            str += ",";
        });
        if (str.length > 0)
        {
            var IDS = str.substr(0, str.length - 1);
            $.dialog.confirm({'msg':js_lang.sure_do},function(){
                tmp = _ajax_com_data(url,'id='+IDS);
                if(tmp)
                {
                    tableReload();
                }
            });
        } 
        else
        {
            $.dialog.alert({'msg':js_lang.select_option});
        }
    });
});
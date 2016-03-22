function _ajax_data(url,temp)
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
				tun = ret.data ? ret.data : -1;
			}
			else
			{
				//$.alert({title: tbt_lang.system_infos,content: ret.msg});
			}
		},
		error: function () {
		  //$.alert({title: tbt_lang.system_infos,content: tbt_lang.server_data_error});
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
	form.on('beforeSubmit', function (e) {
			var $form = $(this);
			$btn.attr('disabled','disabled');
			_ajax_data($form.attr('action'),$form.serialize());
			$btn.removeAttr('disabled','disabled');
		}).on('submit', function (e) {
			e.preventDefault();
		});
}

$(function(){
	$(document).on('click','._save',function(event){
		var form = jQuery('form#'+$(this).attr('date-option'));
		var $btn = $(this);
		if (form.find('.has-error').length)return false;
		ajax_submit(form,$btn);
	})
});
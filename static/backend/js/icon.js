function g_c(type,url,sData)
{
	var cont = {};
	cont.delete ='<a class="btn btn-danger btn-xs _del" data-url="'+url+'" data-parame="'+sData+'"><i class="fa fa-trash fa-1x"></i></a>&nbsp;&nbsp;';
	cont.update = '<a class="btn btn-primary btn-xs _loadModel" data-url="'+url+'"  data-parame="'+sData+'"><i class="fa fa-pencil fa-1x"></i></a>&nbsp;&nbsp;';
	cont.printf = '<a class="btn btn-warning btn-xs _loadModel" data-url="'+url+'"  data-parame="'+sData+'"><i class="fa fa-print fa-1x"></i></a>&nbsp;&nbsp;';
	cont.search = '<a class="btn btn-primary btn-xs _loadModel" data-url="'+url+'"  data-parame="'+sData+'"><i class="fa fa-search fa-1x"></i></a>&nbsp;&nbsp;';
	cont.dwload = '<a class="btn btn-success btn-xs _loadModel" data-url="'+url+'"  data-parame="'+sData+'"><i class="fa fa-cloud-download fa-1x"></i></a>&nbsp;&nbsp;';
	cont.insert = '<a class="btn btn-success btn-xs _loadModel" data-url="'+url+'"  data-parame="'+sData+'"><i class="fa fa-plus fa-1x"></i></a>&nbsp;&nbsp;';
	js_lang.batch_deletion = js_lang.batch_deletion ? js_lang.batch_deletion : sData;
	cont.alldel = '<a class="btn btn-danger btn-sm deleteFun" data-url="'+url+'"  ><i class="fa fa-check-square fa-1x"></i> '+js_lang.batch_deletion+'</a>&nbsp;&nbsp;';
	if(type==1)
	{
		return cont.update;
	}
	else if(type==2)
	{
		return cont.delete;
	}
	else if(type==3)
	{
		return cont.printf;
	}
	else if(type==4)
	{
		return cont.search;
	}
	else if(type==5)
	{
		return cont.dwload;
	}
	else if(type==6)
	{
		return cont.insert;
	}
	else if(type==7)
	{
		return cont.alldel;
	}
}

function g_l(sData)
{
	var cont = {};
	cont.right  = '<a><i class="fa fa-check fa-1x"></i></a>';
	cont.error  = '<a style="color:#ccc"><i class="fa fa-close fa-1x"></i></a>';
	if(sData==1)
	{
		return cont.right;
	}
	else
	{
		return cont.error;
	}
}
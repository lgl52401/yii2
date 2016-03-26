<div class='form-inline'>
    <div class="form-group">
    </div>  <div class="form-group">
    </div>  
</div>
<table id="lgl-table" cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-hover tableCls checkParent">
    <thead>
    <tr>
        <th style="width:15px;padding-right:0px" ><input type="checkbox" class='checkAll'></th>
        <th><?=Yii::t('form_label', 'Id');?></th>
        <th><?=Yii::t('form_label', 'Username');?></th>
        <th><?=Yii::t('form_label', 'Status');?></th>
        <th><?=Yii::t('form_label', 'Reg Time');?></th>
        <th><?=Yii::t('form_label', 'Action');?></th>
    </tr>
    </thead>
    <tbody>
    </tbody>
</table>
 
<?php $this->beginBlock('js'); ?>
<script type="text/javascript">
var oTable;
$(document).ready(function() {
     initTable();
     $('.search').click(function(){
        oTable.fnDraw(); 
     })
})
function retrieveData(sSource, aoData, fnCallback )
{
    var parame  = [];
    var url     = '';
    $.ajax( {     
        type: "POST",      
        url: '<?=$this->nowUrl(["act"=>"load"]); ?>',   
        dataType:"json",  
        data:"pageparam="+JSON.stringify(aoData)+'&'+url, //以json格式传递(struts2后台还是以string类型接受),year和month直接作为参数传递。  
        success: function(data)
        {   
            fnCallback(data); //服务器端返回的对象的returnObject部分是要求的格式     
        }     
    });    
}

function initTable()
{
    oTable = $('#lgl-table').dataTable( {
        'processing'    : true,
        'bPaginate'     : true,
        'bDestory'      : true,
        'bAutoWidth'    : false,//自动宽度
        'bRetrieve'     : true,
        'bFilter'       : false,
        'bSort'         : true,
        'bProcessing'   : true,
        'serverSide'    : true,
        'fnServerData'  :retrieveData,
        'aoColumnDefs'  : [{'bSortable':false,'aTargets':[0,2,3,4,5]}],
        'aaSorting'     : [[ 1, 'desc']]  ,
        'aLengthMenu'   : [30, 50, 100],
        'sDom'          : 'frt<"row-fluid"<"clear" <"alldel"> li>p>',
        'iDisplayLength': 30, 
        "fnCreatedRow": function (nRow, aData, iDataIndex)
                        {
                            $(nRow).click(function () {
                                if ($(this).hasClass('row_selected'))
                                {
                                    $(this).removeClass('row_selected');
                                } 
                                else
                                {
                                    oTable.$('tr.row_selected').removeClass('row_selected');
                                    $(this).addClass('row_selected');
                                }
                            });
                        },
        'oLanguage': 
                    {
                        'sLengthMenu'   : '<?=Yii::t("form_label", "page_sLengthMenu");?>',
                        'sZeroRecords'  : '<?=Yii::t("form_label", "page_sZeroRecords");?>',
                        'sInfo'         : '<?=Yii::t("form_label", "page_sInfo");?>',
                        'sInfoEmpty'    : '<?=Yii::t("form_label", "page_sInfoEmpty");?>',
                        'sInfoFiltered' : '<?=Yii::t("form_label", "page_sInfoFiltered");?>',
                        'sInfoPostFix'  : '',
                        'sSearch'       : '<?=Yii::t("form_label", "page_sSearch");?>:',
                        'oPaginate'     : 
                        {
                            'sFirst'    : '<?=Yii::t("form_label", "page_sFirst");?>',
                            'sPrevious' : '<?=Yii::t("form_label", "page_sPrevious");?>',
                            'sNext'     : '<?=Yii::t("form_label", "page_sNext");?>',
                            'sLast'     : '<?=Yii::t("form_label", "page_sLast");?>'
                        },
                        'sProcessing'   : '<img src="<?php echo staticDir.'/backend/images/loading_line.gif'; ?>" />'
                    },
        'fnInitComplete': function (oSettings, json)
                        {
                            
                        },
        'aoColumns' : [
                        {
                            'mDataProp': 'aid',
                            'fnCreatedCell': function (nTd, sData, oData, iRow, iCol)
                            {
                                $(nTd).html('<input type="checkbox" name="checkList" value="' + sData + '">');
                            }
                        },
                        {'mDataProp': 'aid','sClass': 'text-center','sWidth' : '50px'},
                        {'mDataProp': 'username','sClass': 'text-left'},
                        {'mDataProp': 'status','sClass': 'text-center','sWidth' : '40px'},
                        {'mDataProp': 'reg_time','sClass': 'text-center','sWidth' : '120px'},
                        {
                            'mDataProp': 'aid',
                            'sWidth' : '80px',
                            'fnCreatedCell': function (nTd, sData, oData, iRow, iCol)
                            {
                                var cont ='<a class="btn btn-danger btn-xs _del" data-url="http://admin.e.com/system/delete.shtml?id='+sData+'" href="javascript:void(0);" title="删除"><span class="glyphicon glyphicon-trash"></span></a>';
                                $(nTd).html(cont);
                            }
                        }
                      ]
        });
}    
</script>
<?php $this->endBlock(); ?>
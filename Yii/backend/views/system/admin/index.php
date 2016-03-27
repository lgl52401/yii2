<?php
use yii\helpers\Url;
?>
<div class='form-inline'>
    <div class="form-group">
        <a class="btn btn-primary btn-sm create _loadModel" data-url="<?=Url::to(["system/admin/create"],true) ?>"><i class="fa fa-plus fa-1x"></i> 添加</a>
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
    if($('.dataTables_filter').length)
    {
        $('.dataTables_filter').prepend('<label></label>');
        $('.dataTables_filter label:first').html($('.create'));
    }
})
function retrieveData(sSource, aoData, fnCallback )
{
    var parame  = {};
    var url     = '';
    $.each(parame,function(n,value){
        url += '&'+n+'='+value;
    });
    $.ajax( {     
        type: "POST",      
        url: '<?=$this->nowUrl(["act"=>"load"]); ?>',   
        dataType:"json",  
        data:"pageparam="+JSON.stringify(aoData)+url,
        success: function(data)
        {   
            fnCallback(data);
        }     
    });    
}

function initTable()
{
    oTable = $('#lgl-table').dataTable({
        'fixedHeader'   : true,
        'processing'    : true,
        'bPaginate'     : true,
        'bDestory'      : true,
        'bAutoWidth'    : false,//自动宽度
        'bRetrieve'     : true,
        'bFilter'       : false,
        'bSort'         : true,
        'bProcessing'   : true,
        'serverSide'    : true,
        'fnServerData'  : retrieveData,
        'aoColumnDefs'  : [{'bSortable':false,'aTargets':[0,3,4,5]}],
        'aaSorting'     : [[ 1, 'desc']],
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
                        'sProcessing'   : '<div><p></p></div>'
                    },
        'fnInitComplete': function (oSettings, json)
                        {
                            $('.alldel').html(g_c(7,'<?= Url::to(["system/admin/delete"],true)?>'));
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
                        {'mDataProp': 'status','sClass': 'text-center','sWidth' : '40px',
                            'fnCreatedCell': function (nTd, sData, oData, iRow, iCol)
                            {
                                $(nTd).html(g_l(sData));
                            }
                        },
                        {'mDataProp': 'reg_time','sClass': 'text-center','sWidth' : '100px'},
                        {
                            'mDataProp': 'aid',
                            'sWidth' : '80px',
                            'fnCreatedCell': function (nTd, sData, oData, iRow, iCol)
                            {
                                var i  = g_c(1,'<?=Url::to(["system/admin/update"],true) ?>','id='+sData);
                                    i += g_c(2,'<?=Url::to(["system/admin/delete"],true) ?>','id='+sData);
                                $(nTd).html(i);
                            }
                        }
                      ]
        });
}    
</script>
<?php $this->endBlock(); ?>
<?= $this->render('_form', [
   'model' => $model
]) ?>
<script type="text/javascript">
$(function(){
	$('#admin-username').attr('disabled','disabled');
})
</script>
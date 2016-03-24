<div id="getModal" class="modal  fade" style="display:block">
	<div class="modal-dialog modal-content <?php if(isset($size))echo $size;?>" >
		<div class="modal-header"  id='_modal-header'>
			<button class="close _closeModel" type="button"><i class="fa fa-close"></i></button>
			<h4 id="myModalLabel" class="modal-title"><?php if(isset($htitle))echo $htitle;?></h4>
		</div>
		<?php 
			echo $content;
		?>
	</div>
</div>

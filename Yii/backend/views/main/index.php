<?php
use app\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\url;
?>
<header id="header" class="navbar navbar-static-top" >
	<div class="navbar-header pull-left">
		<a id="button-menu" class="pull-left" type="button">
			<i class="fa fa-indent fa-lg"></i>
		</a>
		<a class="navbar-brand" href="<?= Url::to(['main/'],true)?>">
		</a>
	</div>
	
	<ul class="nav lbreadcrumb pull-left">
		<li>
			<a >
			</a>
		</li>
	</ul>

	<ul class="nav pull-right">
		<li>
			<a data-href="http://www.baidu.com">
				<i class="fa fa-home fa-lg"></i>
			</a>
		</li>
		<li>
			<a id="reload">
				<i class="fa fa-refresh fa-lg"></i>
			</a>
		</li>
		<li class="dropdown">
			<a data-toggle="dropdown" class="dropdown-toggle">
				<i class="fa fa-language fa-lg"></i>
				<?php echo Yii::t('html', Yii::$app->language);?>
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu dropdown-menu-right alerts-dropdown">
				<?php foreach ($langList as $key => $val){?>
		        <li>
		        	<a href="<?= Url::to(['main/','s_lang'=>$key],true)?>">
		        		<img src="<?php echo staticDir.'/icon/'.$key.'.png';?>">&nbsp;&nbsp;<?php echo Yii::t('html', $key);?>
			        </a>
			    </li>
		    	<?php }?>
		    </ul>
		</li>
		<li class="dropdown">
			<a data-toggle="dropdown" class="dropdown-toggle">
				<span class="label label-danger pull-left">27</span> 
				<i class="fa fa-bell fa-lg"></i>
			</a>
			<ul class="dropdown-menu dropdown-menu-right alerts-dropdown">
		        <li class="dropdown-header">Orders</li>
		        <li><a style="display: block; overflow: auto;" href="http://demo.opencartchina.com/admin/index.php?route=sale/order&amp;token=9d429eeb662b03d048d873ddc6355f34&amp;filter_order_status=2"><span class="label label-warning pull-right">0</span>Pending</a></li>
		        <li><a data-href="http://demo.opencartchina.com/admin/index.php?route=sale/order&amp;token=9d429eeb662b03d048d873ddc6355f34&amp;filter_order_status=5"><span class="label label-success pull-right">0</span>Completed</a></li>
		        <li><a href="http://demo.opencartchina.com/admin/index.php?route=sale/return&amp;token=9d429eeb662b03d048d873ddc6355f34"><span class="label label-danger pull-right">8</span>Returns</a></li>
		        <li class="divider"></li>
		        <li class="dropdown-header">Customers</li>
		        <li><a href="http://demo.opencartchina.com/admin/index.php?route=report/customer_online&amp;token=9d429eeb662b03d048d873ddc6355f34"><span class="label label-success pull-right">0</span>Customers Online</a></li>
		        <li><a href="http://demo.opencartchina.com/admin/index.php?route=sale/customer&amp;token=9d429eeb662b03d048d873ddc6355f34&amp;filter_approved=0"><span class="label label-danger pull-right">0</span>Pending approval</a></li>
		        <li class="divider"></li>
		        <li class="dropdown-header">Products</li>
		        <li><a href="http://demo.opencartchina.com/admin/index.php?route=catalog/product&amp;token=9d429eeb662b03d048d873ddc6355f34&amp;filter_quantity=0"><span class="label label-danger pull-right">1</span>Out of stock</a></li>
		        <li><a href="http://demo.opencartchina.com/admin/index.php?route=catalog/review&amp;token=9d429eeb662b03d048d873ddc6355f34&amp;filter_status=0"><span class="label label-danger pull-right">18</span>Reviews</a></li>
		        <li class="divider"></li>
		        <li class="dropdown-header">Affiliates</li>
		        <li><a href="http://demo.opencartchina.com/admin/index.php?route=marketing/affiliate&amp;token=9d429eeb662b03d048d873ddc6355f34&amp;filter_approved=1"><span class="label label-danger pull-right">0</span>Pending approval</a></li>
		    </ul>
		</li>

		<li class="dropdown">
			<a data-toggle="dropdown" class="dropdown-toggle" aria-expanded="false">
				<i class="fa fa-life-ring fa-lg"></i>
			</a>
			<ul class="dropdown-menu dropdown-menu-right">
				<li class="dropdown-header">Stores <i class="fa fa-shopping-cart"></i></li>
				<li><a target="_blank" href="http://demo.opencartchina.com/">Your Store</a></li>
				<li class="divider"></li>
				<li class="dropdown-header">Help <i class="fa fa-life-ring"></i></li>
				<li><a target="_blank" href="http://www.opencart.com">Homepage</a></li>
				<li><a target="_blank" href="http://docs.opencart.com">Documentation</a></li>
				<li><a target="_blank" href="http://forum.opencart.com">Support Forum</a></li>
			</ul>
		</li>

		<li>
			<a href="<?= Url::to(['login/logout'],true)?>">
				<span class="hidden-xs hidden-sm hidden-md"><?php echo Yii::t('html','Logout');?></span> 
				<i class="fa fa-sign-out fa-lg"></i>
			</a>
		</li>
	</ul>
</header>

<nav id="column-left">
	<div id="profile">
		<div>
			<a href="<?= Url::to(['main/'],true)?>">
				<i class="fa fa-user-md fa-lg fa-2x fa-pull-left fa-border"></i>
			</a>
		</div>
		<div class="user-info">
			<h4>demo demod</h4>
			<small>Management System</small>
		</div>
	</div>
	<div id="menu_box">
		<ul id="menu">
			<li>
				<a ><i class="fa fa-dashboard fa-fw"></i><span>Dashboard</span><c class="fa fa-angle-up"></c></a>
				<ul class="first_ul">
					<li>
						<a ><i class="fa fa-angle-double-right"></i><span>Categories</span><c class="fa fa-angle-right"></c></a>
						<ul >
							<li>
								<a data-href="assa" data-breadcrumb='asas'><i class="fa fa-circle-thin"></i><span>Categories</span></a>
							</li>
							<li>
								<a ><i class="fa fa-circle-thin"></i><span>Categories</span></a>
							</li>
							<li>
								<a ><i class="fa fa-circle-thin"></i><span>Categories</span></a>
							</li>
						</ul>
					</li>
					<li>
						<a ><i class="fa fa-angle-double-right"></i><span>Categories</span><c class="fa fa-angle-right"></c></a>
						<ul >
							<li>
								<a data-href="assa" data-breadcrumb='test'><i class="fa fa-circle-thin"></i><span>Categories</span></a>
							</li>
				
						</ul>
					</li>
					<li>
						<a ><i class="fa fa-angle-double-right"></i><span>Categories</span></a>
					</li>
				</ul>
			</li>
			<li>
				<a ><i class="fa fa-tags fa-fw"></i><span>Dashboard</span><c class="fa fa-angle-up"></c></a>
				<ul class="first_ul">
					<li>
						<a ><i class="fa fa-circle-thin"></i><span>Categories</span></a>
					</li>
					<li>
						<a ><i class="fa fa-circle-thin"></i><span>Categories</span></a>
					</li>
					<li>
						<a ><i class="fa fa-circle-thin"></i><span>Categories</span></a>
					</li>
				</ul>
			</li>
			<li>
				<a ><i class="fa fa-dashboard fa-fw"></i><span>Dashboard</span><c class="fa fa-angle-up"></c></a>
			</li>
		</ul>
	</div>
	<div class="scroll" >
        <a onclick="javascript:menuScroll(1);"  class="per" ><i class="fa fa-chevron-up"></i></a>
        <a onclick="menuScroll(2);"  class="next" ><i class="fa fa-chevron-down"></i></a>
    </div>
</nav>

<div id="content">
	<iframe src='' id="rightMain"  frameborder="false" scrolling="auto" width="100%" height="auto" allowtransparency="true"></iframe>
</div>

<?php $this->beginBlock('js'); ?>
<?=Html::jsFile(staticDir.'/backend/js/main.js')?>
<?php $this->endBlock(); ?>

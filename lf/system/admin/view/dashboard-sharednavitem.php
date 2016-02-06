<?php $edit = \lf\get('edit'); ?>
<a id="nav_<?=$action['id'];?>"></a>
<div class="tile white<?=$edit==$action['id']?' active':'';?>">
	<div class="tile-header gray_fg">
		<div class="row">
			<div class="col-4">					
				<?=$action['position'] ? $prefix.$action['position'] : '<i title="hidden" class="fa fa-user-secret"></i>';?>
		
				<a href="%appurl%main/<?=$action['id'];?>/#nav_<?=$action['id'];?>">
					<?=$action['label'];?>
				</a>
			</div>
			<div class="col-4">					
				<a href="%appurl%wysiwyg/<?=$action['id'];?>">WYSIWYG</a>
			</div>
			<div class="col-3">
				<span class="pull-right">
					<?=$theapp;?>
					<?php if( is_file(LF.'apps/'.$theapp.'/admin.php')): ?>
						<a href="<?=\lf\www('Index');?>apps/<?=$theapp;?>/"><i class="fa fa-cog"></i></a>
					<?php else: ?>
						<span><i class="fa fa-cog"></i></span>
					<?php endif; ?>
				</span>
			</div>
			<div class="col-1">
				<a class="x pull-right" <?=jsprompt('Are you sure?');?> href="<?=\lf\www('Index');?>dashboard/rm/<?=$action['id'];?>/"><i class="fa fa-trash-o"></i></a>
			</div>
		</div>
	</div>
	
	<?php if(\lf\www('Param')[1] == $action['id']): /* Load form if selected */ ?>
	<div class="tile-content">
		<?=(new \lf\cms)
			->partial(
				'dashboard-partial-editform', 
				array(
					'save' => $action
				));?>
	</div>
	<?php endif; ?>
</div>
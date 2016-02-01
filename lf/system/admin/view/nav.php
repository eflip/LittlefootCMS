<?php

$admin_apps = str_replace(
	array(ROOT.'apps/', '/admin.php'), '', 
	glob(ROOT.'apps/*/admin.php')
);
	
?>
<h4 class="no_martop"><i class="fa fa-sliders"></i> Control</h4>
<div class="row">
	<div class="col-12">
		<ul class="efvlist rounded fxlarge">
			<?php $this->hook_run('pre lf admin nav'); ?>

			<!-- needs to start with `<li><a class="controls"` so it will match during replacement at index.php -->
			
			<li><a class="controls" href="<?=\lf\www('Index');?>admin/dashboard/"><i class="fa fa-compass"></i><span><?=
				$this->settings['simple_cms']=='_lfcms'
					?' Navigation'
					:ucfirst($this->settings['simple_cms']).' Admin';
				?></span></a></li>
			<li><a class="controls" href="<?=\lf\www('Index');?>admin/skins/"><i class="fa fa-paint-brush"></i><span> Skins</span></a></li>
			<li><a class="controls" href="<?=\lf\www('Index');?>admin/plugins/"><i class="fa fa-plug"></i><span> Plugins</span></a></li>
			<!--<li><a class="media" href="<?=\lf\www('Index');?>admin/media/"><span>Media</span></a></li>-->
			<li><a class="controls" href="<?=\lf\www('Index');?>admin/users/"><i class="fa fa-users"></i><span> Users</span></a></li>
			<li><a class="controls" href="<?=\lf\www('Index');?>admin/acl/"><i class="fa fa-key"></i><span> Access</span></a></li>
			<!-- <li><a class="" href="<?=\lf\www('Index');?>admin/upgrade/"><span>Upgrade</span></a></li> -->
			<li><a class="controls" href="<?=\lf\www('Index');?>admin/settings/"><i class="fa fa-cog"></i><span> Settings</span></a></li>
			<li><a class="controls" href="<?=\lf\www('Index');?>admin/store/"><i class="fa fa-shopping-cart"></i><span> Store</span></a></li>
			<li><a class="controls" target="_blank" href="http://littlefootcms.com/manual/Admin+Documentation" title="Hover over headings for tips!"><i class="fa fa-question"></i><span> Help</span></a></li>
			<li><a class="controls" target="_blank" href="https://github.com/eflip/littlefootcms/issues/"><i class="fa fa-bug"></i><span> Report Bug</span></a></li>
			<!--<li><a class="" href="<?=$this->relbase;?>" target="_blank"><span>Preview Site</span></a></li>-->
			
			<?php $this->hook_run('post lf admin nav'); ?>
		</ul>
	</div>
</div>

<?php if($this->settings['simple_cms'] == '_lfcms'): ?>

<h4><i class="fa fa-th"></i> Apps</h4>
<div class="row">
	<div class="col-12">
		<ul class="efvlist rounded fxlarge">
			<?php
			
			foreach($admin_apps as $shortcut): 
				if(isset($this->action[1]) && $shortcut == $this->action[1]) 
					$highlight = ' class="active blue light_a"';
				else 
					$highlight = '';
				
			?>
				<li<?=$highlight;?>><a class="elements" href="<?=\lf\www('Index');?>admin/apps/<?php echo $shortcut; ?>/">
						<span><?php echo ucfirst($shortcut); ?></span>
				</a></li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>

<?php endif; 
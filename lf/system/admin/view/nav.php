<?php
	$admin_apps = str_replace(
		array(ROOT.'apps/', '/admin.php'), '', 
		glob(ROOT.'apps/*/admin.php')
	);
	
	// $this->settings
?>
<h4 class="no_martop">Control</h4>
<div class="row">
	<div class="col-12">
		<ul class="efvlist rounded">
			<?php $this->lf->hook_run('pre lf admin nav'); ?>

			<li><a class="dashboard" href="<?=$this->base;?>dashboard/"><span>
				<?=$this->settings['simple_cms']=='_lfcms'
					?'Dashboard'
					:ucfirst($this->settings['simple_cms']).' Admin';
				?>
			</span></a></li>
			<li><a class="tables" href="<?=$this->base;?>skins/"><span>Skins</span></a></li>
			<li><a class="tables" href="<?=$this->base;?>plugins/"><span>Plugins</span></a></li>
			<li><a class="editor" href="<?=$this->base;?>store/"><span>Store</span></a></li>
			<!--<li><a class="media" href="<?=$this->base;?>media/"><span>Media</span></a></li>-->
			<li><a class="users" href="<?=$this->base;?>users/"><span>Users</span></a></li>
			<li><a class="editor" href="<?=$this->base;?>acl/"><span>ACL</span></a></li>
			<!-- <li><a class="" href="<?=$this->base;?>upgrade/"><span>Upgrade</span></a></li> -->
			<li><a class="" href="<?=$this->base;?>settings/"><span>Settings</span></a></li>
			<li><a class="" target="_blank" href="http://littlefootcms.com/byname/Admin+Documentation"><span>Help</span></a></li>
			<li><a class="" target="_blank" href="https://github.com/bioshazard/littlefootcms/issues/"><span>Report Bug</span></a></li>
			<!--<li><a class="" href="<?=$this->relbase;?>" target="_blank"><span>Preview Site</span></a></li>-->
			
			<?php $this->lf->hook_run('post lf admin nav'); ?>
		</ul>
	</div>
</div>

<?php if($this->settings['simple_cms'] == '_lfcms'): ?>

<h4>Apps</h4>
<div class="row">
	<div class="col-12">
		<ul class="efvlist rounded">
			<?php foreach($admin_apps as $shortcut): 
				if(isset($this->vars[1]) && $shortcut == $this->vars[1]) $highlight = ' class="active"';
				else $highlight = '';
			?>
				<li <?=$highlight;?>>
					<a class="elements" href="<?=$this->base;?>apps/<?php echo $shortcut; ?>/">
						<span><?php echo ucfirst($shortcut); ?></span>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>

<?php endif; ?>

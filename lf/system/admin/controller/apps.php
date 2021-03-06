<?php

namespace lf\admin;

class apps
{
	public function main()
	{
		$args = \lf\requestGet('Param');
		$var = $args;
		
		if(\lf\getSetting('simple_cms') != '_lfcms') return;
		
		// $var[0] = 'manage'
		$app_name = $var[0];
		echo '<h2 class="no_marbot">
				<a href="'.\lf\requestGet('ActionUrl').$app_name.'/">
					'.ucfirst($app_name).'
				</a> Admin</h2>
			<div class="dashboard_manage">';
		
		$request = (new \lf\request)->load()
			->actionDrop() // drop the 'apps' action in front to cwd
			->actionKeep(1) // make '$app' the new root action
			->save(); 
		
		// manage
		preg_match('/[A-Za-z0-9_]+/', $args[0], $matches);		
		$app_path = ROOT.'apps/'.$matches[0];
		
		$admin = true;
		
		ob_start();
		//if(is_file($app_path.'/'.$preview.'.php'))
		//{ 
			$old = getcwd(); chdir($app_path);
			#$database = $this->dbconn;
			
			include LF.'apps/'.$app_name.'/admin.php';
			
			//echo $this->request->loadapp($app_name, $admin, NULL, $var);
			
			//include($preview.'.php');
			chdir($old);
		//}
		
		echo '</div>';
		
		return \lf\resolveAppUrl( ob_get_clean() );
	}
	
	public function manage($var)
	{
		$var = \lf\requestGet('Param');
		// backward compatible
		redirect302(\lf\requestGet('AdminUrl').'apps/'.$var[1]);
	}
}
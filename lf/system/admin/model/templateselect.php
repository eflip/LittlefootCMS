<?php

$match_file = 'default';
if(isset($save['template']))
	$match_file = $save['template'];
	
$pwd = ROOT.'skins';



$template_select = '<option';
		
if($match_file == 'default')
{
	$template_select .= ' selected="selected"';
	
	$skin = $pwd.'/'.$this->request->settings['default_skin'].'/index.php';
	
	// Get all %replace% keywords for selected template (remove system variables)
	if(!is_file($skin))
	{
		echo 'Currently selected skin does not exist. Please see the Skins tab to correct this.';
		$section_list = array('none');
	}
	else
	{
		$template = file_get_contents($skin);
		preg_match_all("/%([a-z]+)%/", str_replace(array('%baseurl%', '%skinbase%', '%nav%', '%title%'), '', $template), $tokens);
		$section_list = $tokens[1];
	}
}

$template_select .= ' value="default">-- Default Skin ('.$this->request->settings['default_skin'].') --</option>';

foreach(scandir($pwd) as $file)
{
	if($file == '.' || $file == '..') continue;

	$skin = $pwd.'/'.$file.'/index.php';
	if(is_file($skin))
	{
		$template_select .= '<option';
		
		if($match_file == $file)
		{
			$template_select .= ' selected="selected"';
			
			// Get all %replace% keywords for selected template (remove system variables)
			$template = file_get_contents($skin);
			preg_match_all("/%([a-z]+)%/", str_replace(array('%baseurl%', '%nav%', '%title%'), '', $template), $tokens);
			$section_list = $tokens[1];
		}
		
		$template_name = /*$conf['skin'] == $file ? "Default" :*/ ucfirst($file);
		
		$template_select .= ' value="'.$file.'">'.$template_name.'</option>';
	}
}


?>
<?php
/*
# LF Admin

* %adminurl%
* pull latest available lf version

## Route action to controller

* match request[0] to a class in controller/
* extract variables from request
* check nocsrf on POST (should do it on GET too...)
* %variable% replace
* load nav.php
* highlight active navigation item
* hook_run(pre lf render)
* load $admin_skin
* replace %skinbase%
* include $this->lf->head before </head>
* csrf_token replace in <forms>
* print final rendered output

*/

$request = $this->action;

// only admins can see this page
if($this->auth['access'] != 'admin')
	redirect302($this->base);

// so baseurl never changes. make a new one for local admin reference.
$this->adminurl = $this->base.'admin/';

$this->base .= 'admin/'; // backward compatible

// get latest version
if(!isset($_SESSION['upgrade']))
{
	$newversion = file_get_contents('http://littlefootcms.com/files/build-release/littlefoot/lf/system/version');
	if($this->lf->version != $newversion && $this->lf->version != '1-DEV')
		$_SESSION['upgrade'] = $newversion;
	else
		$_SESSION['upgrade'] = false;
}


/* */


// Get a list of admin tools
foreach(scandir('controller') as $controller)
{
	if($controller[0] == '.') continue;
	$controllers[] = str_replace('.php', '', $controller);
}

// Check for valid request
$success = preg_match('/^('.implode('|',$controllers).')$/', $request[0], $match);

// default to dashboard class
if(!$success) $match[0] = 'dashboard';

$this->vars = array_slice($this->action, 1);


//formauth
require_once(ROOT.'system/lib/3rdparty/nocsrf.php');
if(count($_POST))
{
	try
	{
		// Run CSRF check, on POST data, in exception mode, with a validity of 10 minutes, in one-time mode.
		NoCSRF::check( 'csrf_token', $_POST, true, 60*60*10, false );
		// form parsing, DB inserts, etc.
		unset($_POST['csrf_token']);
	}
	catch ( Exception $e )
	{
		// CSRF attack detected
		die('Session timed out');
	}
}

ob_start();
$class = $match[0];
$this->appurl = $this->base.$class.'/';
echo $this->apploader($class);
$replace = array(
	'%appurl%' 	=> $this->lf->base.$class.'/'
);

$app = str_replace(array_keys($replace), array_values($replace), ob_get_clean());

ob_start();
include('view/nav.php');
$nav = ob_get_clean();

// find active nav item
preg_match_all('/<li><a class="[a-z]+" href="('.preg_quote($this->base, '/').'([^\"]+))"/', $nav, $links);
$match = -1;
foreach($links[2] as $id => $request)
	if($request == $class.'/') $match = $id;
$replace = str_replace('<li>', '<li class="active green light_a">', $links[0][$match]);
$nav = str_replace($links[0][$match], $replace, $nav);



//echo $this->hook_run('pre lf render');

echo 'skin/'.$admin_skin.'/index.php';

ob_start();

include('skin/'.$admin_skin.'/index.php');

$replace = array(
	'%baseurl%' => $this->lf->base,
	'%relbase%' => $this->lf->relbase,
	'%adminurl%' => $this->lf->adminurl,
	'%skinbase%' => $this->relbase.'lf/system/admin/skin/'.$admin_skin.'/'
);

$out = str_replace(array_keys($replace), array_values($replace), ob_get_clean());

/* csrf form auth */
	
$out = str_replace('</head>', $this->lf->head.'</head>', $out);

// Generate CSRF token to use in form hidden field
$token = NoCSRF::generate( 'csrf_token' );
preg_match_all('/<form[^>]*action="([^"]+)"[^>]*>/', $out, $match);
for($i = 0; $i < count($match[0]); $i++)
{
	$out = str_replace($match[0][$i], $match[0][$i].' <input type="hidden" name="csrf_token" value="'.$token.'" />', $out);
	
}

echo $out;
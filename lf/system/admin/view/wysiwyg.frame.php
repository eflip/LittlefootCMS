<h2>Dashboard 2.0 (wysiwyg)</h2>

<?=notice();?>

<h3>
	<i class="fa fa-compass"></i> Navigation
</h3>
<div class="row">
	<div class="col-9">
		<div class="row no_martop">
			<div class="col-12">
				<h4>Public</h4>
				<nav class="light_b main_nav white"><?=(new \lf\cms)->renderNavCache( \lf\requestGet('AdminUrl').'wysiwyg/' );?></nav>
			</div>
		</div>
		<div class="row no_martop">
			<div class="col-12">
				<h4>Hidden</h4>
				<nav class="light_b main_nav white"><?=(new \lf\cms)->hiddenList();?></nav>
			</div>
		</div>
		<?php include 'view/wysiwyg.action.php'; ?>
	</div>
	<div class="col-3">
		<?php include 'view/wysiwyg.addlink.php'; ?>
	</div>
</div>

<h4 title="Apps Linked to This Nav Item"><i class="fa fa-link"></i> Linked Apps</h4>

<?php

// loop through linked apps
$links = (new \LfLinks)->getAllByInclude($action['id']);
echo '<div class="row">';
foreach($links as $link)
{
	echo '<div class="col-9">';
	// print editor form for each
	include 'view/wysiwyg.link.php';
	echo '</div>';
}
	
echo '</div>';

$iframeUrl = \lf\requestGet('AdminUrl').'wysiwyg/preview/'.$action['id'].'/'.implode('/', $param);

?>

<a id="preview"></a>
<div class="row">
	<div class="col-9">
		<h4 title="Preview Your Site and Make Updates in Realtime" class="no_martop"><i class="fa fa-eye"></i> Preview <a href="<?=$iframeUrl?>" class="pull-right" title="Fullscreen Preview"><i class="fa fa-arrows-alt"></i></a></h4>
		<iframe src="<?=$iframeUrl?>"
			class="white light_b" width="100%" height="700px" frameborder="0">
		</iframe>
	
	</div>
</div>
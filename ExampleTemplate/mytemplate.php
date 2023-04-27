<?php namespace ProcessWire;

?>

<div id='content' pw-append>
	<p>This is from region page <?= $page->name ?></p>
	<?php $items = $controller->getContentData(); ?>
	<ul>
		<?php foreach($items as $item): ?>
		<li><?= $item['name'] ?></li>
		<?php endforeach; ?>
	</ul>
</div>

<div id='sidebar' pw-append>
	<p>Sidebar from region page <?= $page->name ?></p>
</div>

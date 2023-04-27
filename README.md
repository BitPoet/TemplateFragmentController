# TemplateFragmentController
ProcessWire proof-of-concept module that allows retrieval of individual fragments of a template

# Install
Download the zip from github, extract it into site/modules, refresh your modules in the backend and click "Install".

# How it works
The module parses the template file for markup regions and creates an individual file for each region.

Let's assume the template file here is named "mytemplate.php".

It then loads the controller class for the template, which:
- resides in site/templates as well
- is named the same as the template but prefixed with an underscore with .controller.php instead of .php,
  e.g. _mytemplate.controller.php
- must contain a class MytemplateController.php that extends TemplateFragmentController

You can implement whatever methods needed to retrieve the data for your fragments. With the help
of the controller, all heavy PHP logic is moved out of the template file. Your fragments only
call the relevant pieces of code. This way, only the strictly necessary load is put on the server.

Caveates:
- each region must have a unique id
- actions like append, prepend, replace, after etc. are ignored

# Get started
Write your template file with regions, e.g. site/templates/myfirsttemplate.php
```php
<?php namespace ProcessWire; ?>

<region id='content'>
  <!-- this is where the data is retrieved from the controller: -->
	<?php $items = $controller->getContentData(); ?>
	<p>This is from page <?= $page->name ?></p>
	<ul>
		<?php foreach($items as $item): ?>
		<li><?= $item['name'] ?></li>
		<?php endforeach; ?>
	</ul>
</region>

<region id='sidebar'>
  <p>Sidebar region for page <?= $page->name ?></p>
</region>
```

Create your template controller site/templates/_myfirsttemplate.controller.php
```php
<?php namespace ProcessWire;

class MyfirsttemplateController extends TemplateFragmentController {

    public function getContentData() {
    // Just a mostly static example
	return [
		['name' => 'Hello'],
		['name' => 'World'],
		['name' => $this->page->name]
	];
    }
	
}
```

Create a page with your template. Open it in the browser. The query parameter "regions"
tells PW to only return the regions with the given id and watch the return in your
developer console.
- http://localhost/mypage/?regions=content
- http://localhost/mypage/?regions=content,sidebar
- http://localhost/mypage/?regions=content,sidebar&json=1

The module should notice changes in the template file by its own and parse out the
regions again. If that doesn't work for some reason, append the query parameter
_refresh=1_.


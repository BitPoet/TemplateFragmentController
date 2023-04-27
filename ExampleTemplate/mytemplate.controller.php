<?php namespace ProcessWire;

class MytemplateController extends TemplateFragmentController {

	public function getContentData() {
		return [
			['name' => 'Hello'],
			['name' => 'World'],
			['name' => $this->page->name]
		];
	}
	
}

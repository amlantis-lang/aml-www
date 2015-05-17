<?php

namespace App;

use Nette,
	Model;


/**
 * Homepage presenter.
 */
class HomepagePresenter extends BasePresenter
{

	public function renderDefault()
	{
		//$this->template->lastModified = filemtime(__DIR__ . '/../templates/Homepage/default.latte');
	}

	public function renderSearch()
	{
		$this->template->term = $_GET['search'];
		$this->template->results = ['Sorry for inconvenience, searching is not yet implemented for this website.'];
	}
}

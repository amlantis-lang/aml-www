<?php

namespace App;

use Nette;

/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{
	public function createComponentCssAssetsPipeline()
	{
		return $this->buildRootCssAssetsPipeline()
				->setMedia($this->getDefaultCssAssetsMedia());
	}

	public function createComponentCssPrintAssetsPipeline()
	{
		return $this->buildRootCssAssetsPipeline()
				->setMedia($this->getPrintCssAssetsMedia());
	}

	private function buildRootCssAssetsPipeline()
	{
		$files = new \WebLoader\FileCollection(\WWW_DIR . '/css');
		$compiler = $this->buildCssAssetsPipelineCompiler($files);
		return new \WebLoader\Nette\CssLoader($compiler, $this->template->basePath . '/webtemp');
	}

	private function buildCssAssetsPipelineCompiler($files)
	{
		$compiler = \WebLoader\Compiler::createCssCompiler($files, \WWW_DIR . '/webtemp');
		$compiler->addFileFilter(new \WebLoader\Filter\LessFilter());
		return $compiler;
	}

	private function getDefaultCssAssetsMedia()
	{
		return 'screen,projection,tv';
	}

	private function getPrintCssAssetsMedia()
	{
		return 'print';
	}

	protected function beforeRender()
	{
		$toys = $this->getSession('toys');
		if (!isset($toys->githubRibbon)) {
			$ribbon = $this->getRandomGitHubRibbon();
			$this->template->githubRibbon = $toys->githubRibbon = $ribbon;
		} else {
			$this->template->githubRibbon = $toys->githubRibbon;
		}
	}

	private function getRandomGitHubRibbon()
	{
		$availableRibbons = [
				'https://s3.amazonaws.com/github/ribbons/forkme_right_red_aa0000.png',
				'https://s3.amazonaws.com/github/ribbons/forkme_right_green_007200.png',
				'https://s3.amazonaws.com/github/ribbons/forkme_right_darkblue_121621.png',
				'https://s3.amazonaws.com/github/ribbons/forkme_right_orange_ff7600.png',
				'https://s3.amazonaws.com/github/ribbons/forkme_right_gray_6d6d6d.png',
				'https://s3.amazonaws.com/github/ribbons/forkme_right_white_ffffff.png'
		];
		return $availableRibbons[rand(0, count($availableRibbons) - 1)];
	}
}

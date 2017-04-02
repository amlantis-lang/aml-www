<?php

namespace App;

use Nette;
use WebLoader\Compiler;
use WebLoader\FileCollection;
use WebLoader\Filter\LessFilter;
use WebLoader\Nette\CssLoader;

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
		$files = new FileCollection(\WWW_DIR . '/css');
		$compiler = $this->buildCssAssetsPipelineCompiler($files);
		return new CssLoader($compiler, $this->template->basePath . '/webtemp');
	}

	private function buildCssAssetsPipelineCompiler($files)
	{
		$compiler = Compiler::createCssCompiler($files, \WWW_DIR . '/webtemp');
		$compiler->addFileFilter(new LessFilter());
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
}

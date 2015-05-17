<?php

namespace App;

use Coral\Compiler\Tokenizer\Contexts\Context;
use Coral\Compiler\Tokenizer\LegacyTokenizerEngine;
use Nette,
	Model;

class LearnPresenter extends BasePresenter
{
	public function renderBrowseLibrary($library, $path = '/')
	{
		$path = \strtr($path, ['/../' => '/']);

		if ($library === 'CSL') {
			$directoryPath = CSL_DIR . $path;
			if (file_exists($directoryPath)) {
				$directoryEntries = [];

				if ($path !== '/') {
					array_push(
						$directoryEntries,
						[
							'kind' => 'up'
						]
					);
				}

				/**
				 * @var \DirectoryIterator $entry
				 */
				foreach ((new \DirectoryIterator($directoryPath)) as $entry) {
					$file = $entry->getFileInfo();
					if (!$file->isLink() && !$entry->isDot()) {
						if ($file->isFile() && preg_match('~\.coral$~', $file->getBasename())) {
							array_push(
								$directoryEntries,
								[
									'kind' => 'coral',
									'name' => $file->getFilename(),
									'path' => strtr($file->getPathname(), [$directoryPath => '/'])
								]
							);
						} elseif ($file->isDir()) {
							array_push(
								$directoryEntries,
								[
									'kind' => 'module',
									'name' => $file->getFilename(),
									'path' => strtr($file->getPathname(), [$directoryPath => '/'])
								]
							);
						}
					}
				}

				$this->template->directoryEntries = $directoryEntries;
			}
		}
	}

	public function renderPrintDoc($path)
	{
		$this->template->file = $path;
		$this->template->className = $this->pathToClassName($path);
		$tokenizer = new LegacyTokenizerEngine(Context::FileGlobal);
		\ob_start();
		$tokenizer->printFormattedFile(CSL_DIR . $path);
		$this->template->tokenized = \ob_get_clean();
	}

	private function pathToClassName($path)
	{
		$real_path = \strtr($path, [CSL_DIR => null]);
		return \strtr($real_path, ['/' => '::', '.coral' => null]);
	}
}

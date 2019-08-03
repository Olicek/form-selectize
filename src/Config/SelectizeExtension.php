<?php declare(strict_types = 1);
/**
 * Copyright (c) 2014 Petr Olišar (http://olisar.eu)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */

namespace Oli\Selectize\Config;

use Nette;
use Nette\PhpGenerator as Code;
use Oli\Selectize\SelectizeOptions;

/**
 * Description of ControlsExtension
 *
 * @author Petr Olišar <petr.olisar@gmail.com>
 */
class SelectizeExtension extends Nette\DI\CompilerExtension
{

	/**
	 * @var array
	 */
	private $defaults =  [
	    'mode' => 'full',
	    'create' => true,
	    'maxItems' => null,
	    'delimiter' => '#/',
	    'plugins' => ['remove_button'],
	    'valueField' => 'id',
	    'labelField' => 'name',
	    'searchField' => 'name'
	];


	/**
	 * @throws \Nette\InvalidArgumentException
	 * @throws \Nette\InvalidStateException
	 */
	public function loadConfiguration(): void
	{
		$config = $this->getConfig($this->defaults);
		$builder = $this->getContainerBuilder();
		$builder->addDefinition($this->prefix('selectizeOptions'))
			->setFactory(SelectizeOptions::class, [$config['mode']])
			->addSetup('setCanCreate', [$config['create']])
			->addSetup('setMaxItems', [$config['maxItems']])
			->addSetup('setDelimiter', [$config['delimiter']])
			->addSetup('setPlugins', [$config['plugins']])
			->addSetup('setValueFieldName', [$config['valueField']])
			->addSetup('setLabelFieldName', [$config['labelField']])
			->addSetup('setSearchFieldName', [$config['searchField']]);
	}


	/**
	 * @param \Nette\PhpGenerator\ClassType $class
	 */
	public function afterCompile(Code\ClassType $class): void
	{
		parent::afterCompile($class);
		$init = $class->methods['initialize'];
		$init->addBody(RegisterSelectizeControl::class . '::register("addSelectize", $this->getService("selectize.selectizeOptions"));');
	}

}

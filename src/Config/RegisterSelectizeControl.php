<?php declare(strict_types = 1);

namespace Oli\Selectize\Config;

use Nette\Forms\Container;
use Oli\Selectize\SelectizeControl;
use Oli\Selectize\SelectizeOptions;

/**
 * Class RegisterSelectizeControl
 * Copyright (c) 2017 Sportisimo s.r.o.
 * @package Oli\Selectize\Config
 */
class RegisterSelectizeControl
{

	/**
	 * @param string $method
	 * @param $config
	 */
	public static function register(string $method, ?SelectizeOptions $config): void
	{
		Container::extensionMethod($method, static function (Container $container, $name, $label, $entity = null, ?SelectizeOptions $options = null) use ($config)
		{
			$container[$name] = new SelectizeControl($label, $entity, $options ?? $config);
			return $container[$name];
		});
	}

}

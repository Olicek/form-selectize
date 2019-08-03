<?php declare(strict_types = 1);

/**
 * Copyright (c) 2014 Petr Olišar (http://olisar.eu)
 *
 * For the full copyright and license information, please view
 * the file LICENSE.md that was distributed with this source code.
 */

namespace Oli\Selectize;

use Doctrine\ORM\PersistentCollection;
use Kdyby\Doctrine\Collections\ReadOnlyCollectionWrapper;
use Nette;
use Nette\Forms\Form;

/**
 * Description of Selectize
 * @author Petr Olišar <petr.olisar@gmail.com>
 */
class SelectizeControl extends Nette\Forms\Controls\BaseControl
{

	/**
	 * @var array|mixed[]
	 */
	private $entity;

	/**
	 * @var array|mixed|null
	 */
	private $selectize;

	/**
	 * @var
	 */
	private $selectizeBack;

	/**
	 * @var \Oli\Selectize\SelectizeOptions
	 */
	private $options;

	/**
	 * @var bool|string
	 */
	private $prompt = FALSE;


	/**
	 * Selectize constructor.
	 * @param string|null $label
	 * @param array|null $entity
	 * @param \Oli\Selectize\SelectizeOptions $options
	 */
	public function __construct(?string $label = null, array $entity = NULL, SelectizeOptions $options = NULL)
	{
		parent::__construct($label);
		$this->entity = $entity ?? [];
		$this->options = $options ?? new SelectizeOptions(SelectizeOptions::MODE_FULL);
	}


	/**
	 * @param \Oli\Selectize\SelectizeOptions $options
	 * @return \Oli\Selectize\SelectizeControl
	 */
	public function setOptions(SelectizeOptions $options): self
	{
		$this->options = $options;
		return $this;
	}


	/**
	 * @param string $mode
	 * @return \Oli\Selectize\SelectizeControl
	 */
	public function setMode(string $mode): self
	{
		$this->options->setMode($mode);
		return $this;
	}


	/**
	 * @param bool $create
	 * @return \Oli\Selectize\SelectizeControl
	 */
	public function setCreate(bool $create): self
	{
		$this->options->setCanCreate($create);
		return $this;
	}


	/**
	 * @param int|null $items
	 * @return \Oli\Selectize\SelectizeControl
	 */
	public function maxItems(?int $items): self
	{
		$this->options->setMaxItems($items);
		return $this;
	}


	/**
	 * @param string $delimiter
	 * @return \Oli\Selectize\SelectizeControl
	 */
	public function setDelimiter(string $delimiter): self
	{
		$this->options->setDelimiter($delimiter);
		return $this;
	}


	/**
	 * @param array|string[] $plugins
	 * @return $this
	 */
	public function setPlugins(array $plugins): self
	{
		$this->options->setPlugins($plugins);
		return $this;
	}


	/**
	 * @param string $valueField
	 * @return \Oli\Selectize\SelectizeControl
	 */
	public function setValueField(string $valueField): self
	{
		$this->options->setValueFieldName($valueField);
		return $this;
	}


	/**
	 * @param string $labelField
	 * @return \Oli\Selectize\SelectizeControl
	 */
	public function setLabelField(string $labelField): self
	{
		$this->options->setLabelFieldName($labelField);
		return $this;
	}


	/**
	 * @param string|null $searchField
	 * @return \Oli\Selectize\SelectizeControl
	 */
	public function setSearchField(?string $searchField): self
	{
		$this->options->setSearchFieldName($searchField);
		return $this;
	}


	/**
	 * @param string $class
	 * @return \Oli\Selectize\SelectizeControl
	 */
	public function setClass(string $class): self
	{
		$this->options->setCssClassName($class);
		return $this;
	}


	/**
	 * @param $ajaxURL
	 * @return $this
	 */
	public function setAjaxURL(?string $ajaxURL): self
	{
		$this->options->setAjaxURL($ajaxURL);
		return $this;
	}


	/**
	 * Sets first prompt item in select box.
	 * @param  string|bool
	 * @return self
	 */
	public function setPrompt($prompt): self
	{
		$this->prompt = $prompt;
		return $this;
	}


	/**
	 * Returns first prompt item?
	 * @return string|bool
	 */
	public function getPrompt()
	{
		return $this->prompt;
	}


    /**
     * Sets options and option groups from which to choose.
     * @param array|mixed[] $items
     * @return self
     */
    public function setItems(array $items): self
	{
        $this->entity = $items;

        return $this;
    }


	/**
	* Gets items
	* @return array|mixed[]
	*/
	public function getItems(): array
	{
        return $this->entity;
	}


	/**
	 * @param $value
	 * @return \Oli\Selectize\SelectizeControl
	 * @throws \Nette\InvalidArgumentException
	 */
	public function setValue($value): self
	{
		if(!is_null($value))
		{
			if ($value instanceof Nette\Database\Table\Selection)
			{
				// TODO: Predelat na vlastni vyjimku
				throw new Nette\InvalidArgumentException("Type must be array, instance of Nette\\Database\\Table\\Selection was given. Try Selection::fetchAssoc(\$key)");
			}

			if(is_array($value) || $value instanceof ReadOnlyCollectionWrapper || $value instanceof PersistentCollection)
			{
				$i = 0;
				foreach($value as $key => $slug)
				{
					$i++;
					$idName = $this->options->getValueFieldName();
					$this->selectizeBack .= $slug->$idName ?? $key;

					if($i < count($value))
					{
						$this->selectizeBack .= $this->options->getDelimiter();
					}
				}
			} else
			{
				$this->selectizeBack = $value;
			}
		}

		$this->selectize = $this->selectizeBack;
		return $this;
	}


	/**
	 * @return array|mixed|null
	 */
	public function getValue()
	{
		if (is_array($this->selectize) && count($this->selectize) === 0) {
			return null;
		}
		return $this->selectize;
	}


	/**
	 * Loads HTTP data.
	 * @return void
	 */
	public function loadHttpData(): void
	{
		if($this->options->getMode() === 'select')
		{
			$value = $this->getHttpData(Form::DATA_LINE);
			if($value === '')
			{
				$value = null;
			}
			$this->selectizeBack = $this->selectize = $value;
		} else
		{
			$this->prepareData();
		}
	}


	/**
	 * @return \Nette\Utils\Html|string
	 * @throws \Nette\InvalidArgumentException
	 */
	public function getControl()
	{
		$this->setOption('rendered', TRUE);
		$name = $this->getHtmlName();
        $el = clone $this->control;
        if ($this->options->getAjaxURL() !== null)
        {
            $this->entity = $this->findActiveValue($this->entity, $this->options->getValueFieldName(), $this->selectizeBack);
        }

		if($this->options->getMode() === 'full')
		{
			return $el->addAttributes([
				'id' => $this->getHtmlId(),
				'type' => 'text',
				'name' => $name,
				'class' => array($this->options->getCssClassName() ?? 'selectize' . ' form-control text'),
				'data-entity' => $this->entity,
				'data-options' => $this->options,
				'value' => $this->selectizeBack
			]);
		}

		if($this->options->getMode() === 'select')
		{
			$this->entity = $this->prompt === FALSE ?
				$this->entity : self::arrayUnshiftAssoc($this->entity, '', $this->translate($this->prompt));
			return Nette\Forms\Helpers::createSelectBox($this->entity, [
					'selected?' => $this->selectizeBack
				])
				->id($this->getHtmlId())
				->name($name)
				->data('entity', $this->entity)
				->data('options', $this->options)
				->class($this->options->getCssClassName() ?? 'selectize' . ' form-control')
				->addAttributes(parent::getControl()->attrs)
						->setValue($this->selectizeBack);
		}

		throw new Nette\InvalidArgumentException('Unknown type of selectize.');
	}


	/**
	 * @param $array
	 * @param $key
	 * @param $value
	 * @return array
	 */
    public function findActiveValue($array, $key, $value): array
	{
        $results = array();

        if (is_array($array)) {
            if (isset($array[$key]) && $array[$key] == $value) {
                $results[] = $array;
            }

            foreach ($array as $subarray) {
                $results = array_merge($results, $this->findActiveValue($subarray, $key, $value));
            }
        }

        return $results;
    }


	/**
	 * @param $arr
	 * @param $key
	 * @param $val
	 * @return array
	 */
	private static function arrayUnshiftAssoc(&$arr, $key, $val): array
	{
		$arr = array_reverse($arr, true);
		$arr[$key] = $val;
		return array_reverse($arr, true);
	}


	private function prepareData(): void
	{
		$this->selectize = $this->split($this->getHttpData(Form::DATA_LINE));
		$this->selectizeBack = $this->getHttpData(Form::DATA_LINE);
		$iteration = false;
		foreach($this->selectize as $key => $value)
		{
			if(!$this->myInArray($this->entity, $value, $this->options->getValueFieldName()))
			{
				$iteration ?: $this->selectize['new'] = [];
				$this->entity[] = [
					$this->options->getValueFieldName() => $value,
					'name' => $value
				];
				$this->selectize['new'][] = $value;
				unset($this->selectize[$key]);
				$iteration = true;
			}
		}
	}


	/**
	 * @param $selectize
	 * @return array
	 */
	private function split(string $selectize): array
	{
		$return = Nette\Utils\Strings::split($selectize, '~'.$this->options->getDelimiter().'\s*~');
		return $return[0] === '' ? [] : $return;
	}


	/**
	 *
	 * @author <brouwer.p@gmail.com>
	 * @param array $array
	 * @param string|int $value
	 * @param string|int $key
	 * @return boolean
	 */
	private function myInArray(array $array, $value, $key): bool
	{
		if(isset($array[$key]) && $array[$key] == $value)
		{
			return true;
		}

		foreach ($array as $val)
		{
			if (is_array($val) && $this->myInArray($val, $value, $key))
			{
				return true;
			}
		}
		return false;
	}

}

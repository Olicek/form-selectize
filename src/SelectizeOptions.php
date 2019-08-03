<?php declare(strict_types = 1);

namespace Oli\Selectize;

use JsonSerializable;
use Nette\Utils\Json;

/**
 * Class SelectizeOptions
 * Copyright (c) 2017 Sportisimo s.r.o.
 * @package src
 */
class SelectizeOptions implements JsonSerializable
{

	public const MODE_FULL = 'full';

	public const MODE_SELECT = 'select';

	/**
	 * @var string
	 */
	private $mode;

	/**
	 * If can be set new value out of existing dataset.
	 * @var bool
	 */
	private $canCreate = false;

	/**
	 * How many items can be selected. In mode select this setting throw exception.
	 * @var null|int
	 */
	private $maxItems = null;

	/**
	 * @var string
	 */
	private $delimiter = '#/';

	/**
	 * Used plugins.
	 * @var array|string[]
	 */
	private $plugins = [];

	/**
	 * @var null|string
	 */
	private $valueFieldName = null;

	/**
	 * @var null|string
	 */
	private $labelFieldName = null;

	/**
	 * @var null|string
	 */
	private $searchFieldName = null;

	/**
	 * @var string
	 */
	private $cssClassName = 'selectize';

	/**
	 * @var null|string
	 */
	private $ajaxURL = null;


	/**
	 * SelectizeOptions constructor.
	 * @param string|null $mode
	 */
	public function __construct(string $mode)
	{
		$this->mode = $mode;
	}


	/**
	 * @return string|null
	 */
	public function getMode(): ?string
	{
		return $this->mode;
	}


	/**
	 * @param string $mode
	 * @return SelectizeOptions
	 */
	public function setMode(string $mode): SelectizeOptions
	{
		$this->mode = $mode;

		return $this;
	}


	/**
	 * @return bool
	 */
	public function isCanCreate(): bool
	{
		return $this->canCreate;
	}


	/**
	 * @param bool $canCreate
	 * @return SelectizeOptions
	 */
	public function setCanCreate(bool $canCreate): SelectizeOptions
	{
		$this->canCreate = $canCreate;

		return $this;
	}


	/**
	 * @return int|null
	 */
	public function getMaxItems(): ?int
	{
		return $this->maxItems;
	}


	/**
	 * @param int|null $maxItems
	 * @return SelectizeOptions
	 */
	public function setMaxItems(?int $maxItems): SelectizeOptions
	{
		$this->maxItems = $maxItems;

		return $this;
	}


	/**
	 * @return string
	 */
	public function getDelimiter(): string
	{
		return $this->delimiter;
	}


	/**
	 * @param string $delimiter
	 * @return SelectizeOptions
	 */
	public function setDelimiter(string $delimiter): SelectizeOptions
	{
		$this->delimiter = $delimiter;

		return $this;
	}


	/**
	 * @return array|string[]
	 */
	public function getPlugins(): array
	{
		return $this->plugins;
	}


	/**
	 * @param array|string[] $plugins
	 * @return SelectizeOptions
	 */
	public function setPlugins($plugins): SelectizeOptions
	{
		$this->plugins = $plugins;

		return $this;
	}


	/**
	 * @return string|null
	 */
	public function getValueFieldName(): ?string
	{
		return $this->valueFieldName;
	}


	/**
	 * @param string|null $valueFieldName
	 * @return SelectizeOptions
	 */
	public function setValueFieldName(?string $valueFieldName): SelectizeOptions
	{
		$this->valueFieldName = $valueFieldName;

		return $this;
	}


	/**
	 * @return string|null
	 */
	public function getLabelFieldName(): ?string
	{
		return $this->labelFieldName;
	}


	/**
	 * @param string|null $labelFieldName
	 * @return SelectizeOptions
	 */
	public function setLabelFieldName(?string $labelFieldName): SelectizeOptions
	{
		$this->labelFieldName = $labelFieldName;

		return $this;
	}


	/**
	 * @return string|null
	 */
	public function getSearchFieldName(): ?string
	{
		return $this->searchFieldName;
	}


	/**
	 * @param string|null $searchFieldName
	 * @return SelectizeOptions
	 */
	public function setSearchFieldName(?string $searchFieldName): SelectizeOptions
	{
		$this->searchFieldName = $searchFieldName;

		return $this;
	}


	/**
	 * @return string
	 */
	public function getCssClassName(): string
	{
		return $this->cssClassName;
	}


	/**
	 * @param string $cssClassName
	 * @return SelectizeOptions
	 */
	public function setCssClassName(string $cssClassName): SelectizeOptions
	{
		$this->cssClassName = $cssClassName;

		return $this;
	}


	/**
	 * @return string|null
	 */
	public function getAjaxURL(): ?string
	{
		return $this->ajaxURL;
	}


	/**
	 * @param string|null $ajaxURL
	 * @return SelectizeOptions
	 */
	public function setAjaxURL(?string $ajaxURL): SelectizeOptions
	{
		$this->ajaxURL = $ajaxURL;

		return $this;
	}


	/**
	 * @return string
	 * @throws \Nette\Utils\JsonException
	 */
	public function __toString(): string
	{
		return Json::encode($this->jsonSerialize());
	}


	public function jsonSerialize(): array
	{
		return get_object_vars($this);
	}

}

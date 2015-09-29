form-selectize
==============

Form extension for Nette framework

## Requirements

* Nette 2.2+
* jQuery 1.8+
* [Selectize] (https://github.com/brianreavis/selectize.js)

## Installation

The best way to install olicek/form-selectize is using  [Composer](http://getcomposer.org/):

```sh
$ composer require olicek/form-selectize:dev-master
```

After installation server site, you have to install client site. 
Download from [brianreavis/selectize.js](https://github.com/brianreavis/selectize.js/tree/master/dist) or use [bower](http://bower.io/search/?q=selectize)

Next step is copy [server-site](https://github.com/Olicek/form-selectize/blob/master/client-side/selectize.js) script from this extension to www dir and link it to appliacation.

Last step is enable the extension using your neon config

```
extensions:
	selectize: App\Form\Control\SelectizeExtension
```

## Default configuration

```
selectize:
	mode: full # second mode is `select` for selection just 1 option
	create: on
	maxItems: null
	delimiter: #/
	plugins:
		- remove_button
	valueField: id
	labelField: name
	searchField: name
```


## Data in array for full mode

```
array (2)
	0 => array (2)
		id => 1
		name => "First item"
	1 => array (2)
		id => 2
		name => "Second item"
```
id is set as valueField and name as labelField and searchField in config.neon. You can use whatever, have to just set in config.neon or in addSelectize method. For example: 
```
valueField: slug
```

## Using

#### Default settings from config.neon

```php
$form->addSelectize('tags', 'štítky', $arrayData);
```

#### custome settings in method first way (array)
```php
$form->addSelectize('tags', 'štítky', $arrayData, ['create' => false, 'maxItems' => 3]);
```

#### custome settings in method first way (method)

```php
$form->addSelectize('tags', 'štítky', $arrayData)->setValueField('slug')->delimiter('_');
```

## Output is:

#### Select mode

```
dump($form->values->tags); // return "1"
```

#### Full mode
In full mode it will return array with valueField values. If you create some new tag, it will in sub array with plain text.

```
array (3)
	0 => "1"
	1 => "2"
	new => array (1)
		0 => "Third item"
```

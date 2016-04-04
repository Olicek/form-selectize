
Ajax
====

If you want to load options asynchronously, you can easily use ajax. In your php file you will need some handler for signal and say selectzie,
url for this signal.

```
$form->addSelectize('author', 'Author:', NULL,
	[
		'mode' => 'select',
		'class' => 'author-selectize'
	])
	->setAjaxURL($this->link('ajax!'));
```

And handler:

```
public function handleAjax($query)
{
	$query = $this->request->getQuery('query');
	$result = $this->authorRepository->createQueryBuilder()
		->select('t.id, t.name')
		->from(Author::class, 't')
		->where('t.name LIKE :name')->setParameter('name', $query . '%')->getQuery()->getResult();
	$this->getPresenter()->sendJson($result);
}
```

And thats all. After typing 3 characters it will search and return options.

Realy important is, that it must **return associative array**
with valueField and labelField columns set before. Response from this handler looks like:

```
{
    0: {
        id: 1,
        name: "Chuck Norris"
    },
    1: {
        id: 2,
        name: "Franta Vomáčka"
    },
    ...
}
```
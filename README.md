# Hydrator

## Installation

### Composer

The preferred way to install this extension is through [Composer](http://getcomposer.org/).

Either run

```
php composer.phar require zelenin/hydrator "dev-master"
```

or add

```
"zelenin/hydrator": "dev-master"
```

to the require section of your ```composer.json```

## Usage

### Example

```php
$entity = new Entity(5, 'Title');

$hydrator = new StrategyHydrator(new ReflectionStrategy(), new RawNamingStrategy());

$data = $hydrator->extract($entity);
// $data = ['id' => 5, 'name' => 'Title']

$data = ['id' => 10, 'name' => 'New title'];

$newEntity = $hydrator->hydrate($entity, $data);
// $newEntity->getId() = 10, $newEntity->getName() = 'New title'
```

## Author

[Aleksandr Zelenin](https://github.com/zelenin/), e-mail: [aleksandr@zelenin.me](mailto:aleksandr@zelenin.me)

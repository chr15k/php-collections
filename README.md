# PHP Collections

## Approach

I implemented a Collection interface to standardize common operations (insert, remove, contains, iteration`). Type safety is ensured using PHPStan at the maximum level, while Rector and Pint maintain consistent code quality and best practices. Testing is done with Pest and the Pest coverage plugin, achieving 100% coverage of all functionality.

## Installation

```bash
composer install
```

## Testing

Run the full test suite:

```bash
composer test
```

Run only unit tests:

```bash
composer test:unit
```

Run type checks (PHPStan):

```bash
composer test:types
```

Run code style checks (Pint):

```bash
composer test:lint
```

Run code refactoring (Rector):

```bash
composer test:rector
```

Apply linting and refactoring (runs both Pint and Rector):
```bash
composer tidy
```

## Usage

```php
use Chr15k\Collection\SortedLinkedList;

$list = new SortedLinkedList();
$list->insert(5);
$list->insert(3);
$list->insert(8);
$list->insert(1);

// The list is always sorted
print_r($list->toArray()); // [1, 3, 5, 8]

// Remove a value
$list->remove(3);
print_r($list->toArray()); // [1, 5, 8]

// Check if a value exists
if ($list->contains(5)) {
    echo "5 is in the list!";
}

// Iterate over the list
foreach ($list as $value) {
    echo $value . PHP_EOL;
}

// Get the number of elements
echo $list->count(); // 3
```

## Extending

To create your own collection type, implement the Collection interface and follow the type-safety pattern.

Here is a simple code sample for an ItegerStack:

```php
<?php

use Chr15k\Collection\Contracts\Collection;

class IntegerStack implements Collection
{
    /** @var int[] */
    private array $items = [];

    public function insert(mixed $item): void
    {
        if (!is_int($item)) {
            throw new \InvalidArgumentException("Only integers allowed.");
        }
        array_push($this->items, $item);
    }

    public function remove(mixed $item): void
    {
        $index = array_search($item, $this->items, true);
        if ($index !== false) {
            array_splice($this->items, $index, 1);
        }
    }

    public function contains(mixed $item): bool
    {
        return in_array($item, $this->items, true);
    }

    public function count(): int
    {
        return count($this->items);
    }

    public function toArray(): array
    {
        return $this->items;
    }

    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->items);
    }
}

// Usage
$stack = new IntegerStack();
$stack->insert(5);
$stack->insert(10);
$stack->remove(5);

foreach ($stack as $value) {
    echo $value . PHP_EOL;
}
```

## License

MIT

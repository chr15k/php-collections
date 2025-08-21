<?php

declare(strict_types=1);

namespace Chr15k\Collection\Contracts;

use Countable;
use IteratorAggregate;
use Traversable;

/**
 * @template T of int|string
 *
 * @extends IteratorAggregate<int,T>
 */
interface Collection extends Countable, IteratorAggregate
{
    /**
     * Insert a value into the list at the correct sorted position.
     *
     * @param  T  $value
     */
    public function insert(int|string $value): void;

    /**
     * Remove the first occurrence of a value from the list.
     *
     * @param  T  $value
     * @return bool True if removed, false if not found.
     */
    public function remove(int|string $value): bool;

    /**
     * Check if a value exists in the list.
     *
     * @param  T  $value
     */
    public function contains(int|string $value): bool;

    /**
     * Convert the list to a array.
     *
     * @return list<T>
     */
    public function toArray(): array;

    /**
     * @return Traversable<int,T>
     */
    public function getIterator(): Traversable;

    /**
     * @return int Number of elements in the list
     */
    public function count(): int;
}

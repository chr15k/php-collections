<?php

declare(strict_types=1);

namespace Chr15k\Collection;

use Chr15k\Collection\Contracts\Collection;
use Traversable;
use TypeError;

/**
 * @template T of int|string
 *
 * @implements Collection<T>
 */
final class SortedLinkedList implements Collection
{
    /** @var Node<T>|null */
    private ?Node $head = null;

    private int $size = 0;

    private ?string $type = null;

    public function insert(int|string $value): void
    {
        $this->enforceSameType($value);

        $newNode = new Node($value);

        if (! $this->head instanceof Node || $value < $this->head->value) {
            $newNode->next = $this->head;
            $this->head = $newNode;
        } else {
            $current = $this->head;
            while ($current->next instanceof Node && $current->next->value < $value) {
                $current = $current->next;
            }
            $newNode->next = $current->next;
            $current->next = $newNode;
        }

        $this->size++;
    }

    public function remove(int|string $value): bool
    {
        if (! $this->head instanceof Node) {
            return false;
        }

        if ($this->head->value === $value) {
            $this->head = $this->head->next;
            $this->size--;

            return true;
        }

        $current = $this->head;
        while ($current->next instanceof Node) {
            if ($current->next->value === $value) {
                $current->next = $current->next->next;
                $this->size--;

                return true;
            }
            $current = $current->next;
        }

        return false;
    }

    public function contains(int|string $value): bool
    {
        $current = $this->head;
        while ($current instanceof Node) {
            if ($current->value === $value) {
                return true;
            }
            $current = $current->next;
        }

        return false;
    }

    public function toArray(): array
    {
        $values = [];
        $current = $this->head;
        while ($current instanceof Node) {
            $values[] = $current->value;
            $current = $current->next;
        }

        return $values;
    }

    public function count(): int
    {
        return $this->size;
    }

    /**
     * Opted for a generator to yield values for better memory efficiency.
     */
    public function getIterator(): Traversable
    {
        $current = $this->head;
        while ($current instanceof Node) {
            yield $current->value;
            $current = $current->next;
        }
    }

    /**
     * Ensures the list only contains values of the same type.
     */
    private function enforceSameType(int|string $value): void
    {
        $valueType = get_debug_type($value);

        if ($this->type === null) {
            $this->type = $valueType;
        }

        if ($valueType !== $this->type) {
            throw new TypeError("This list only accepts {$this->type} values, {$valueType} given.");
        }
    }
}

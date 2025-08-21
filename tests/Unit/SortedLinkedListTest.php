<?php

declare(strict_types=1);

use Chr15k\Collection\SortedLinkedList;

it('can create a new SortedLinkedList instance', function (): void {
    $list = new SortedLinkedList;
    expect($list)->toBeInstanceOf(SortedLinkedList::class);
});

it('can insert values in sorted order', function (): void {
    $list = new SortedLinkedList;
    $list->insert(5);
    $list->insert(3);
    $list->insert(8);
    $list->insert(1);

    expect($list->toArray())->toEqual([1, 3, 5, 8]);
});

it('can remove values', function (): void {
    $list = new SortedLinkedList;
    $list->insert(5);
    $list->insert(3);
    $list->insert(8);
    $list->insert(1);

    expect($list->remove(3))->toBeTrue();
    expect($list->toArray())->toEqual([1, 5, 8]);

    expect($list->remove(10))->toBeFalse(); // Non-existent value
});

it('can handle duplicate values', function (): void {
    $list = new SortedLinkedList;
    $list->insert(5);
    $list->insert(3);
    $list->insert(5); // Duplicate
    $list->insert(1);

    expect($list->toArray())->toEqual([1, 3, 5, 5]);
    expect($list->remove(5))->toBeTrue();
    expect($list->toArray())->toEqual([1, 3, 5]);
});

it('can handle type consistency', function (): void {
    $list = new SortedLinkedList;
    $list->insert(5);
    $list->insert(3);

    expect(fn () => $list->insert('string'))->toThrow(TypeError::class);

    // Ensure it still works with integers
    expect($list->toArray())->toEqual([3, 5]);
});

it('can iterate over the list', function (): void {
    $list = new SortedLinkedList;
    $list->insert(5);
    $list->insert(3);
    $list->insert(8);
    $list->insert(1);

    $values = [];
    foreach ($list as $value) {
        $values[] = $value;
    }

    expect($values)->toEqual([1, 3, 5, 8]);
});

it('can convert to array', function (): void {
    $list = new SortedLinkedList;
    $list->insert(5);
    $list->insert(3);
    $list->insert(8);
    $list->insert(1);

    expect($list->toArray())->toEqual([1, 3, 5, 8]);
});

it('can count the number of elements', function (): void {
    $list = new SortedLinkedList;
    $list->insert(5);
    $list->insert(3);
    $list->insert(8);
    $list->insert(1);

    expect($list->count())->toBe(4);

    $list->remove(3);
    expect($list->count())->toBe(3);
});

it('returns false when removing from an empty list', function (): void {
    $list = new SortedLinkedList;
    expect($list->remove(1))->toBeFalse();
});

it('returns false when checking contains on empty list', function (): void {
    $list = new SortedLinkedList;
    expect($list->contains(1))->toBeFalse();
});

it('returns true for contains on present value', function (): void {
    $list = new SortedLinkedList;
    $list->insert(42);
    expect($list->contains(42))->toBeTrue();
});

it('returns false for contains on absent value', function (): void {
    $list = new SortedLinkedList;
    $list->insert(42);
    expect($list->contains(99))->toBeFalse();
});

it('returns empty array for toArray on empty list', function (): void {
    $list = new SortedLinkedList;
    expect($list->toArray())->toEqual([]);
});

it('returns 0 for count on empty list', function (): void {
    $list = new SortedLinkedList;
    expect($list->count())->toBe(0);
});

it('removes the head node correctly', function (): void {
    $list = new SortedLinkedList;
    $list->insert(2);
    $list->insert(1); // 1 becomes head
    expect($list->toArray())->toEqual([1, 2]);
    expect($list->remove(1))->toBeTrue(); // Remove head
    expect($list->toArray())->toEqual([2]);
    expect($list->count())->toBe(1);
});

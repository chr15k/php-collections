<?php

declare(strict_types=1);

namespace Chr15k\Collection;

/**
 * @internal
 *
 * @template T of int|string
 */
final class Node
{
    /** @var Node<T>|null */
    public ?Node $next = null;

    /**
     * @param  T  $value
     */
    public function __construct(public int|string $value)
    {
        //
    }
}

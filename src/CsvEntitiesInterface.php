<?php

declare(strict_types=1);

namespace Koriym\CsvEntities;

interface CsvEntitiesInterface
{
    /**
     * @param class-string<T> $className
     *
     * @return list<T>
     *
     * @template T as object
     * @no-named-arguments
     */
    public function __invoke(string $className, string|null ...$csvs): array;

    /**
     * @param non-empty-string $separator
     * @param class-string<T>  $className
     *
     * @return list<T>
     *
     * @template T as object
     * @no-named-arguments
     */
    public function get(string $separator, string $className, string|null ...$csvs): array;
}

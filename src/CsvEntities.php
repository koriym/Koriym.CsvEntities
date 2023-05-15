<?php

declare(strict_types=1);

namespace Koriym\CsvEntities;

use function array_column;
use function array_map;
use function assert;
use function count;
use function explode;
use function method_exists;

final class CsvEntities implements CsvEntitiesInterface
{
    /** @param non-empty-string $separator */
    public function __construct(
        private string $separator = '/',
    ) {
    }

    /**
     * {@inheritDoc}
     *
     * @no-named-arguments
     */
    public function __invoke(string $className, string|null ...$csvs): array
    {
        $separator = $this->separator;
        $arrays = array_map(static fn (string|null $csv) => empty($csv) ? [] : explode($separator, $csv), [...$csvs]);
        $length = count($arrays[0]);
        $entities = [];
        for ($i = 0; $i < $length; $i++) {
            $args = array_column($arrays, $i);
            assert(method_exists($className, '__construct'));
            /** @psalm-suppress MixedMethodCall */
            $entities[] = new $className(...$args);
        }

        return $entities;
    }
}

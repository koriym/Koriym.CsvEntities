<?php

declare(strict_types=1);

namespace Koriym\CsvEntities;

use PHPUnit\Framework\TestCase;

class CsvEntitiesTest extends TestCase
{
    public function testInvoke(): void
    {
        $memos = (new CsvEntities())(Memo::class, '1,2', 'run,walk');
        $this->assertContainsOnlyInstancesOf(
            className: Memo::class,
            haystack: $memos,
        );
        $this->assertSame(['1', 'run'], [$memos[0]->id, $memos[0]->title]);
        $this->assertSame(['2', 'walk'], [$memos[1]->id, $memos[1]->title]);
    }
}

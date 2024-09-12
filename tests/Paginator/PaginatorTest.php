<?php declare(strict_types=1);

namespace App\Tests\Paginator;

use App\Paginator\Paginator;
use PHPUnit\Framework\TestCase;

class PaginatorTest extends TestCase
{
    public function testPaginator(): void
    {
        $paginator = new Paginator(2, 200, 5);
        $this->assertEquals(5, $paginator->getCurrentPage());
        $this->assertEquals(2, $paginator->getItemsPerPage());
        $this->assertEquals(200, $paginator->getTotalItems());
        $this->assertEquals(100, $paginator->getTotalPages());
    }
}

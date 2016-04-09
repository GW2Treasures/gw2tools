<?php

namespace GW2Treasures\GW2Tools\Tests\Common;

use GW2Treasures\GW2Tools\Common\ItemStack;
use GW2Treasures\GW2Tools\Tests\TestCase;

class ItemStackTest extends TestCase {
    public function testFromArray() {
        $itemStack = ItemStack::fromArray([
            'id' => 42,
            'count' => 1337,
            'foo' => 'bar'
        ]);

        $this->assertEquals(42, $itemStack->id);
        $this->assertEquals(1337, $itemStack->count);
        $this->assertEquals('bar', $itemStack->foo);
    }

    public function testFromObject() {
        $itemStack = ItemStack::fromObject((object)[
            'id' => 42,
            'count' => 1337,
            'foo' => 'bar'
        ]);

        $this->assertEquals(42, $itemStack->id);
        $this->assertEquals(1337, $itemStack->count);
        $this->assertEquals('bar', $itemStack->foo);
    }
}

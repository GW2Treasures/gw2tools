<?php

namespace GW2Treasures\GW2Tools\Tests\Chatlinks;

use GW2Treasures\GW2Tools\Tests\TestCase;
use GW2Treasures\GW2Tools\Chatlinks\Chatlink;
use GW2Treasures\GW2Tools\Chatlinks\ItemChatlink;
use GW2Treasures\GW2Tools\Common\ItemStack;

class ChatlinkTest extends TestCase {
    public function testItemChatLinkDecodeSimple() {
        /** @var ItemChatlink $chatlink */
        $chatlink = Chatlink::decode( '[&AgEJTQAA]' );

        $this->assertEquals( Chatlink::TYPE_ITEM, $chatlink->getType() );
        $this->assertInstanceOf( ItemChatlink::class, $chatlink );

        $itemStack = $chatlink->getItemStack();

        $this->assertInstanceOf( ItemStack::class, $itemStack );

        $this->assertEquals( 1, $itemStack->count );
        $this->assertEquals( 19721, $itemStack->id );
    }

    public function testItemChatLinkDecodeUpgrades() {
        /** @var ItemChatLink $chatlink */
        $chatlink = Chatlink::decode( '[&AgGqtgDgfQ4AAP9fAAAnYAAA]' );

        $this->assertEquals( Chatlink::TYPE_ITEM, $chatlink->getType() );
        $this->assertInstanceOf( ItemChatlink::class, $chatlink );

        $itemStack = $chatlink->getItemStack();

        $this->assertInstanceOf( ItemStack::class, $itemStack );

        $this->assertEquals( 1, $itemStack->count );
        $this->assertEquals( 46762, $itemStack->id );
        $this->assertEquals( 3709, $itemStack->skin );
        $this->assertEquals( [24575, 24615], $itemStack->upgrades );
    }

    public function testItemChatLinkEncodeSimple() {
        $itemStack = ItemStack::fromArray([
            'count' => 1,
            'id' => 19721
        ]);

        $chatlink = new ItemChatLink( $itemStack );

        $this->assertEquals( 19721, $chatlink->getItemStack()->id );

        $chatcode = $chatlink->encode();

        $this->assertEquals( '[&AgEJTQAA]', $chatcode );
    }


    public function testItemChatLinkEncodeUpgrades() {
        $itemStack = ItemStack::fromArray([
            'count' => 1,
            'id' => 46762,
            'skin' => 3709,
            'upgrades' => [24575, 24615]
        ]);

        $chatlink = new ItemChatLink( $itemStack );

        $chatcode = $chatlink->encode();
        $this->assertEquals( '[&AgGqtgDgfQ4AAP9fAAAnYAAA]', $chatcode );
    }
}

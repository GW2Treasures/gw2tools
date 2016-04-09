<?php

namespace GW2Treasures\GW2Tools\Tests\Chatlinks;

use GW2Treasures\GW2Tools\Chatlinks\Chatlink;
use GW2Treasures\GW2Tools\Chatlinks\ItemChatlink;
use GW2Treasures\GW2Tools\Common\ItemStack;
use GW2Treasures\GW2Tools\Tests\TestCase;

class ItemChatlinkTest extends TestCase {
    /**
     * @expectedException \GW2Treasures\GW2Tools\Chatlinks\Exceptions\InvalidChatlinkTypeException
     */
    public function testDecodesOnlyItemChatlinks() {
        ItemChatlink::decode('[&AQAAAAA=]');
    }

    /**
     * @expectedException \GW2Treasures\GW2Tools\Chatlinks\Exceptions\ChatlinkFormatException
     */
    public function testDecodeInvalidChatlink() {
        ItemChatlink::decode('[&AgAAAAAAAAAAAAAAA]');
    }

    public function testItemChatLinkDecodeSimple() {
        $chatlink = ItemChatlink::decode('[&AgEJTQAA]');

        $itemStack = $chatlink->getItemStack();

        $this->assertInstanceOf(ItemStack::class, $itemStack, 'ItemChatlink::getItemStack should return an ItemStack');

        $this->assertEquals(1, $itemStack->count, 'ItemChatlink should decode the item count correctly');
        $this->assertEquals(19721, $itemStack->id, 'ItemChatlink should decode the item id correctly');
    }

    public function testItemChatLinkDecodeUpgrades() {
        $chatlink = ItemChatlink::decode('[&AgGqtgDgfQ4AAP9fAAAnYAAA]');

        $itemStack = $chatlink->getItemStack();

        $this->assertEquals(1, $itemStack->count, 'ItemChatlink should decode the item count correctly');
        $this->assertEquals(46762, $itemStack->id, 'ItemChatlink should decode the item id correctly');
        $this->assertEquals(3709, $itemStack->skin, 'ItemChatlink should decode the item skin correctly');
        $this->assertEquals([24575, 24615], $itemStack->upgrades, 'ItemChatlink should decode the item upgrades correctly');
    }

    public function testItemChatLinkEncodeSimple() {
        $itemStack = ItemStack::fromArray([
            'count' => 1,
            'id' => 19721
        ]);

        $chatlink = new ItemChatlink($itemStack);

        $this->assertSame($itemStack, $chatlink->getItemStack(), 'ItemChatlink should return the correct ItemStack instance');

        $chatcode = $chatlink->encode();

        $this->assertEquals('[&AgEJTQAA]', $chatcode, 'ItemChatlink should encode the ItemStack correctly');
    }


    public function testItemChatLinkEncodeUpgrades() {
        $itemStack = ItemStack::fromArray([
            'count' => 1,
            'id' => 46762,
            'skin' => 3709,
            'upgrades' => [24575, 24615]
        ]);

        $chatlink = new ItemChatlink($itemStack);

        $chatcode = $chatlink->encode();
        $this->assertEquals('[&AgGqtgDgfQ4AAP9fAAAnYAAA]', $chatcode, 'ItemChatlink should encode the ItemStack correctly');
    }
}

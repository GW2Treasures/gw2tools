<?php

namespace GW2Treasures\GW2Tools\Tests\Chatlinks;

use GW2Treasures\GW2Tools\Tests\TestCase;
use GW2Treasures\GW2Tools\Chatlinks\Chatlink;
use GW2Treasures\GW2Tools\Chatlinks\ItemChatlink;

class ChatlinkTest extends TestCase {
    function testDecodeItemChatlink() {
        $chatlink = Chatlink::decode('[&AgEJTQAA]');
        
        $this->assertInstanceOf(ItemChatlink::class, $chatlink,
            "Decoding an item chatlink should return an instance of ItemChatlink");
        $this->assertEquals(Chatlink::TYPE_ITEM, $chatlink->getType(),
            "Decoded item chatlink should have the type item");
    }

    /**
     * @expectedException \GW2Treasures\GW2Tools\Chatlinks\Exceptions\UnknownChatlinkTypeException
     */
    function testDecodeUnknownChatlink() {
        Chatlink::decode('[&0gEJTQAA]');
    }

    /**
     * @expectedException \GW2Treasures\GW2Tools\Chatlinks\Exceptions\ChatlinkFormatException
     */
    function testDecodeMalformedChatlink() {
        Chatlink::decode('not a chatlink');
    }
}

<?php

namespace GW2Treasures\GW2Tools\Tests\Chatlinks;

use GW2Treasures\GW2Tools\Chatlinks\TraitChatlink;
use GW2Treasures\GW2Tools\Tests\TestCase;

class TraitChatlinkTest extends TestCase {
    /**
     * @expectedException \GW2Treasures\GW2Tools\Chatlinks\Exceptions\InvalidChatlinkTypeException
     */
    public function testDecodesOnlyTraitChatlinks() {
        TraitChatlink::decode('[&AgEJTQAA]');
    }

    /**
     * @expectedException \GW2Treasures\GW2Tools\Chatlinks\Exceptions\ChatlinkFormatException
     */
    public function testDecodeInvalidChatlink() {
        TraitChatlink::decode('[&CPIDAAAAAAAA]');
    }

    public function testDecode() {
        $this->assertEquals(1010, TraitChatlink::decode('[&CPIDAAA=]')->getId());
    }

    public function testEncode() {
        $this->assertEquals('[&CPIDAAA=]', (new TraitChatlink(1010))->encode());
    }
}

<?php

namespace GW2Treasures\GW2Tools\Tests\Chatlinks;

use GW2Treasures\GW2Tools\Chatlinks\TraitChatlink;
use GW2Treasures\GW2Tools\Tests\BasicTestCase;

class TraitChatlinkTest extends BasicTestCase {
    /**
     */
    public function testDecodesOnlyTraitChatlinks() {
        $this->expectException(\GW2Treasures\GW2Tools\Chatlinks\Exceptions\InvalidChatlinkTypeException::class);

        TraitChatlink::decode('[&AgEJTQAA]');
    }

    /**
     */
    public function testDecodeInvalidChatlink() {
        $this->expectException(\GW2Treasures\GW2Tools\Chatlinks\Exceptions\ChatlinkFormatException::class);

        TraitChatlink::decode('[&B/IDAAAinvalid]');
    }

    public function testDecode() {
        $this->assertEquals(1010, TraitChatlink::decode('[&B/IDAAA=]')->getId());
    }

    public function testEncode() {
        $this->assertEquals('[&B/IDAAA=]', (new TraitChatlink(1010))->encode());
    }
}

<?php

namespace GW2Treasures\GW2Tools\Tests\Chatlinks;

use GW2Treasures\GW2Tools\Chatlinks\OutfitChatlink;
use GW2Treasures\GW2Tools\Tests\TestCase;

class OutfitChatlinkTest extends TestCase {
    /**
     * @expectedException \GW2Treasures\GW2Tools\Chatlinks\Exceptions\InvalidChatlinkTypeException
     */
    public function testDecodesOnlySkillChatlinks() {
        OutfitChatlink::decode('[&AgEJTQAA]');
    }

    /**
     * @expectedException \GW2Treasures\GW2Tools\Chatlinks\Exceptions\ChatlinkFormatException
     */
    public function testDecodeInvalidChatlink() {
        OutfitChatlink::decode('[&CwEAAAAinvalid]');
    }

    public function testDecode() {
        $this->assertEquals(1, OutfitChatlink::decode('[&CwEAAAA=]')->getId());
        $this->assertEquals(33, OutfitChatlink::decode('[&CyEAAAA=]')->getId());
        $this->assertEquals(12, OutfitChatlink::decode('[&CwwAAAA=]')->getId());
    }

    public function testEncode() {
        $this->assertEquals('[&CwEAAAA=]', (new OutfitChatlink(1))->encode());
        $this->assertEquals('[&CyEAAAA=]', (new OutfitChatlink(33))->encode());
        $this->assertEquals('[&CwwAAAA=]', (new OutfitChatlink(12))->encode());
    }
}

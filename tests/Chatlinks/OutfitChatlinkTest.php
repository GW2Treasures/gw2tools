<?php

namespace GW2Treasures\GW2Tools\Tests\Chatlinks;

use GW2Treasures\GW2Tools\Chatlinks\SkinChatlink;
use GW2Treasures\GW2Tools\Tests\TestCase;

class OutfitChatlinkTest extends TestCase {
    /**
     * @expectedException \GW2Treasures\GW2Tools\Chatlinks\Exceptions\InvalidChatlinkTypeException
     */
    public function testDecodesOnlySkillChatlinks() {
        SkinChatlink::decode('[&AgEJTQAA]');
    }

    /**
     * @expectedException \GW2Treasures\GW2Tools\Chatlinks\Exceptions\ChatlinkFormatException
     */
    public function testDecodeInvalidChatlink() {
        SkinChatlink::decode('[&CwEAAAAinvalid]');
    }

    public function testDecode() {
        $this->assertEquals(1, SkinChatlink::decode('[&CwEAAAA=]')->getId());
        $this->assertEquals(33, SkinChatlink::decode('[&CyEAAAA=]')->getId());
        $this->assertEquals(12, SkinChatlink::decode('[&CwwAAAA=]')->getId());
    }

    public function testEncode() {
        $this->assertEquals('[&CwEAAAA=]', (new SkinChatlink(1))->encode());
        $this->assertEquals('[&CyEAAAA=]', (new SkinChatlink(33))->encode());
        $this->assertEquals('[&CwwAAAA=]', (new SkinChatlink(12))->encode());
    }
}

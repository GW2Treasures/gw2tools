<?php

namespace GW2Treasures\GW2Tools\Tests\Chatlinks;

use GW2Treasures\GW2Tools\Chatlinks\SkinChatlink;
use GW2Treasures\GW2Tools\Tests\BasicTestCase;

class SkinChatlinkTest extends BasicTestCase {
    /**
     */
    public function testDecodesOnlySkillChatlinks() {
        $this->expectException(\GW2Treasures\GW2Tools\Chatlinks\Exceptions\InvalidChatlinkTypeException::class);

        SkinChatlink::decode('[&AgEJTQAA]');
    }

    /**
     */
    public function testDecodeInvalidChatlink() {
        $this->expectException(\GW2Treasures\GW2Tools\Chatlinks\Exceptions\ChatlinkFormatException::class);

        SkinChatlink::decode('[&CgIAAAAinvalid]');
    }

    public function testDecode() {
        $this->assertEquals(2, SkinChatlink::decode('[&CgIAAAA=]')->getId());
        $this->assertEquals(1079, SkinChatlink::decode('[&CjcEAAA=]')->getId());
        $this->assertEquals(5743, SkinChatlink::decode('[&Cm8WAAA=]')->getId());
    }

    public function testEncode() {
        $this->assertEquals('[&CgIAAAA=]', (new SkinChatlink(2))->encode());
        $this->assertEquals('[&CjcEAAA=]', (new SkinChatlink(1079))->encode());
        $this->assertEquals('[&Cm8WAAA=]', (new SkinChatlink(5743))->encode());
    }
}

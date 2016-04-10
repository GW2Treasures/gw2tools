<?php

namespace GW2Treasures\GW2Tools\Tests\Chatlinks;

use GW2Treasures\GW2Tools\Chatlinks\SkinChatlink;
use GW2Treasures\GW2Tools\Tests\TestCase;

class SkinChatlinkTest extends TestCase {
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
        SkinChatlink::decode('[&C7cQAAAinvalid]');
    }

    public function testDecode() {
        $this->assertEquals(20, SkinChatlink::decode('[&CxQAAAA=]')->getId());
        $this->assertEquals(6003, SkinChatlink::decode('[&C3MXAAA=]')->getId());
        $this->assertEquals(4279, SkinChatlink::decode('[&C7cQAAA=]')->getId());
    }

    public function testEncode() {
        $this->assertEquals('[&CxQAAAA=]', (new SkinChatlink(20))->encode());
        $this->assertEquals('[&C3MXAAA=]', (new SkinChatlink(6003))->encode());
        $this->assertEquals('[&C7cQAAA=]', (new SkinChatlink(4279))->encode());
    }
}

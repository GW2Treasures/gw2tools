<?php

namespace GW2Treasures\GW2Tools\Tests\Chatlinks;

use GW2Treasures\GW2Tools\Chatlinks\SkillChatlink;
use GW2Treasures\GW2Tools\Tests\TestCase;

class SkillChatlinkTest extends TestCase {
    /**
     * @expectedException \GW2Treasures\GW2Tools\Chatlinks\Exceptions\InvalidChatlinkTypeException
     */
    public function testDecodesOnlySkillChatlinks() {
        SkillChatlink::decode('[&AgEJTQAA]');
    }

    /**
     * @expectedException \GW2Treasures\GW2Tools\Chatlinks\Exceptions\ChatlinkFormatException
     */
    public function testDecodeInvalidChatlink() {
        SkillChatlink::decode('[&B+cCAAAAAAA]');
    }

    public function testDecode() {
        $this->assertEquals(743, SkillChatlink::decode('[&B+cCAAA=]')->getId());
        $this->assertEquals(5491, SkillChatlink::decode('[&B3MVAAA=]')->getId());
        $this->assertEquals(5501, SkillChatlink::decode('[&B30VAAA=]')->getId());
    }

    public function testEncode() {
        $this->assertEquals('[&B+cCAAA=]', (new SkillChatlink(743))->encode());
        $this->assertEquals('[&B3MVAAA=]', (new SkillChatlink(5491))->encode());
        $this->assertEquals('[&B30VAAA=]', (new SkillChatlink(5501))->encode());
    }
}

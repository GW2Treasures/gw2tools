<?php

namespace GW2Treasures\GW2Tools\Tests\Chatlinks;

use GW2Treasures\GW2Tools\Chatlinks\SkillChatlink;
use GW2Treasures\GW2Tools\Tests\BasicTestCase;

class SkillChatlinkTest extends BasicTestCase {
    /**
     */
    public function testDecodesOnlySkillChatlinks() {
        $this->expectException(\GW2Treasures\GW2Tools\Chatlinks\Exceptions\InvalidChatlinkTypeException::class);

        SkillChatlink::decode('[&AgEJTQAA]');
    }

    /**
     */
    public function testDecodeInvalidChatlink() {
        $this->expectException(\GW2Treasures\GW2Tools\Chatlinks\Exceptions\ChatlinkFormatException::class);

        SkillChatlink::decode('[&BpcEAAAinvalid]');
    }

    public function testDecode() {
        $this->assertEquals(1175, SkillChatlink::decode('[&BpcEAAA=]')->getId());
        $this->assertEquals(5491, SkillChatlink::decode('[&BnMVAAA=]')->getId());
        $this->assertEquals(5501, SkillChatlink::decode('[&Bn0VAAA=]')->getId());
    }

    public function testEncode() {
        $this->assertEquals('[&BpcEAAA=]', (new SkillChatlink(1175))->encode());
        $this->assertEquals('[&BnMVAAA=]', (new SkillChatlink(5491))->encode());
        $this->assertEquals('[&Bn0VAAA=]', (new SkillChatlink(5501))->encode());
    }
}

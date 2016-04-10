<?php

namespace GW2Treasures\GW2Tools\Tests\Chatlinks;

use GW2Treasures\GW2Tools\Chatlinks\RecipeChatlink;
use GW2Treasures\GW2Tools\Tests\TestCase;

class RecipeChatlinkTest extends TestCase {
    /**
     * @expectedException \GW2Treasures\GW2Tools\Chatlinks\Exceptions\InvalidChatlinkTypeException
     */
    public function testDecodesOnlyRecipeChatlinks() {
        RecipeChatlink::decode('[&AgEJTQAA]');
    }

    /**
     * @expectedException \GW2Treasures\GW2Tools\Chatlinks\Exceptions\ChatlinkFormatException
     */
    public function testDecodeInvalidChatlink() {
        RecipeChatlink::decode('[&CQEAAAAinvalid]');
    }

    public function testDecode() {
        $this->assertEquals(1, RecipeChatlink::decode('[&CQEAAAA=]')->getId());
        $this->assertEquals(2, RecipeChatlink::decode('[&CQIAAAA=]')->getId());
        $this->assertEquals(7, RecipeChatlink::decode('[&CQcAAAA=]')->getId());
    }

    public function testEncode() {
        $this->assertEquals('[&CQEAAAA=]', (new RecipeChatlink(1))->encode());
        $this->assertEquals('[&CQIAAAA=]', (new RecipeChatlink(2))->encode());
        $this->assertEquals('[&CQcAAAA=]', (new RecipeChatlink(7))->encode());
    }
}

<?php

namespace GW2Treasures\GW2Tools\Tests\Chatlinks;

use GW2Treasures\GW2Tools\Chatlinks\RecipeChatlink;
use GW2Treasures\GW2Tools\Tests\BasicTestCase;

class RecipeChatlinkTest extends BasicTestCase {
    /**
     */
    public function testDecodesOnlyRecipeChatlinks() {
        $this->expectException(\GW2Treasures\GW2Tools\Chatlinks\Exceptions\InvalidChatlinkTypeException::class);

        RecipeChatlink::decode('[&AgEJTQAA]');
    }

    /**
     */
    public function testDecodeInvalidChatlink() {
        $this->expectException(\GW2Treasures\GW2Tools\Chatlinks\Exceptions\ChatlinkFormatException::class);

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

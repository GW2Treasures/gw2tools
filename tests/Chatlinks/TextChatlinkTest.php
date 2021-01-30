<?php

namespace GW2Treasures\GW2Tools\Tests\Chatlinks;

use GW2Treasures\GW2Tools\Chatlinks\TextChatlink;
use GW2Treasures\GW2Tools\Tests\BasicTestCase;

class TextChatlinkTest extends BasicTestCase {
    /**
     */
    public function testDecodesOnlyTextChatlinks() {
        $this->expectException(\GW2Treasures\GW2Tools\Chatlinks\Exceptions\InvalidChatlinkTypeException::class);

        TextChatlink::decode('[&AgEJTQAA]');
    }

    /**
     */
    public function testDecodeInvalidChatlink() {
        $this->expectException(\GW2Treasures\GW2Tools\Chatlinks\Exceptions\ChatlinkFormatException::class);

        TextChatlink::decode('[&AxgnAAAAAAAinvalid]');
    }

    public function testDecode() {
        $this->assertEquals(258, TextChatlink::decode('[&AwIBAAA=]')->getId());
        $this->assertEquals(51200, TextChatlink::decode('[&AwDIAAA=]')->getId());
        $this->assertEquals(10000, TextChatlink::decode('[&AxAnAAA=]')->getId());
        $this->assertEquals(359, TextChatlink::decode('[&A2cBAAA=]')->getId());
    }

    public function testEncode() {
        $this->assertEquals('[&AwIBAAA=]', (new TextChatlink(258))->encode());
        $this->assertEquals('[&AwDIAAA=]', (new TextChatlink(51200))->encode());
        $this->assertEquals('[&AxAnAAA=]', (new TextChatlink(10000))->encode());
        $this->assertEquals('[&A2cBAAA=]', (new TextChatlink(359))->encode());
    }
}

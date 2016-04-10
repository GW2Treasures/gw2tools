<?php

namespace GW2Treasures\GW2Tools\Tests\Chatlinks;

use GW2Treasures\GW2Tools\Chatlinks\CoinChatlink;
use GW2Treasures\GW2Tools\Tests\TestCase;

class CoinChatlinkTest extends TestCase {
    /**
     * @expectedException \GW2Treasures\GW2Tools\Chatlinks\Exceptions\InvalidChatlinkTypeException
     */
    public function testDecodesOnlyCoinChatlinks() {
        CoinChatlink::decode('[&AgEJTQAA]');
    }

    /**
     * @expectedException \GW2Treasures\GW2Tools\Chatlinks\Exceptions\ChatlinkFormatException
     */
    public function testDecodeInvalidChatlink() {
        CoinChatlink::decode('[&AQAAAAAAAAA]');
    }

    public function testDecode() {
        $this->assertEquals(0, CoinChatlink::decode('[&AQAAAAA=]')->getCopper());
        $this->assertEquals(1, CoinChatlink::decode('[&AQEAAAA=]')->getCopper());
        $this->assertEquals(10203, CoinChatlink::decode('[&AdsnAAA=]')->getCopper());
        $this->assertEquals(4294967295, CoinChatlink::decode('[&Af////8=]')->getCopper());
    }

    public function testEncode() {
        $this->assertEquals('[&AQAAAAA=]', (new CoinChatlink(0))->encode());
        $this->assertEquals('[&AQEAAAA=]', (new CoinChatlink(1))->encode());
        $this->assertEquals('[&AdsnAAA=]', (new CoinChatlink(10203))->encode());
        $this->assertEquals('[&Af////8=]', (new CoinChatlink(4294967295))->encode());
    }
}

<?php

namespace GW2Treasures\GW2Tools\Tests\Chatlinks;

use GW2Treasures\GW2Tools\Chatlinks\MapChatlink;
use GW2Treasures\GW2Tools\Tests\TestCase;

class MapChatlinkTest extends TestCase {
    /**
     * @expectedException \GW2Treasures\GW2Tools\Chatlinks\Exceptions\InvalidChatlinkTypeException
     */
    public function testDecodesOnlyMapChatlinks() {
        MapChatlink::decode('[&AgEJTQAA]');
    }

    /**
     * @expectedException \GW2Treasures\GW2Tools\Chatlinks\Exceptions\ChatlinkFormatException
     */
    public function testDecodeInvalidChatlink() {
        MapChatlink::decode('[&BDgAAAAinvalid]');
    }

    public function testDecode() {
        $this->assertEquals(56, MapChatlink::decode('[&BDgAAAA=]')->getId());
        $this->assertEquals(825, MapChatlink::decode('[&BDkDAAA=]')->getId());
        $this->assertEquals(1757, MapChatlink::decode('[&BN0GAAA=]')->getId());
        $this->assertEquals(1869, MapChatlink::decode('[&BE0HAAA=]')->getId());
    }

    public function testEncode() {
        $this->assertEquals('[&BDgAAAA=]', (new MapChatlink(56))->encode());
        $this->assertEquals('[&BDkDAAA=]', (new MapChatlink(825))->encode());
        $this->assertEquals('[&BN0GAAA=]', (new MapChatlink(1757))->encode());
        $this->assertEquals('[&BE0HAAA=]', (new MapChatlink(1869))->encode());
    }
}

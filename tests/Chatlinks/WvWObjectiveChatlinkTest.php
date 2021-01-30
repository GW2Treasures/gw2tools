<?php

namespace GW2Treasures\GW2Tools\Tests\Chatlinks;

use GW2Treasures\GW2Tools\Chatlinks\WvWObjectiveChatlink;
use GW2Treasures\GW2Tools\Tests\BasicTestCase;

class WvWObjectiveChatlinkTest extends BasicTestCase {
    /**
     */
    public function testDecodesOnlyTraitChatlinks() {
        $this->expectException(\GW2Treasures\GW2Tools\Chatlinks\Exceptions\InvalidChatlinkTypeException::class);

        WvWObjectiveChatlink::decode('[&AgEJTQAA]');
    }

    /**
     */
    public function testDecodeInvalidChatlink() {
        $this->expectException(\GW2Treasures\GW2Tools\Chatlinks\Exceptions\ChatlinkFormatException::class);

        WvWObjectiveChatlink::decode('[&DGYAAABOBAAAinvalid]');
    }

    public function testDecode() {
        $this->assertEquals('1102-102', WvWObjectiveChatlink::decode('[&DGYAAABOBAAA]')->getId());
    }

    public function testEncode() {
        $this->assertEquals('[&DGYAAABOBAAA]', (new WvWObjectiveChatlink('1102-102'))->encode());
        $this->assertEquals('[&DGYAAABOBAAA]', (new WvWObjectiveChatlink(102, 1102))->encode());
    }

    /**
     */
    public function testInvalidObjectiveId() {
        $this->expectException(\InvalidArgumentException::class);

        new WvWObjectiveChatlink('102-asd');
    }

    /**
     */
    public function testInvalidMissingMapId() {
        $this->expectException(\InvalidArgumentException::class);

        new WvWObjectiveChatlink(102);
    }
}

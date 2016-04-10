<?php

namespace GW2Treasures\GW2Tools\Tests\Chatlinks;

use GW2Treasures\GW2Tools\Chatlinks\WvWObjectiveChatlink;
use GW2Treasures\GW2Tools\Tests\TestCase;

class WvWObjectiveChatlinkTest extends TestCase {
    /**
     * @expectedException \GW2Treasures\GW2Tools\Chatlinks\Exceptions\InvalidChatlinkTypeException
     */
    public function testDecodesOnlyTraitChatlinks() {
        WvWObjectiveChatlink::decode('[&AgEJTQAA]');
    }

    /**
     * @expectedException \GW2Treasures\GW2Tools\Chatlinks\Exceptions\ChatlinkFormatException
     */
    public function testDecodeInvalidChatlink() {
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
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidObjectiveId() {
        new WvWObjectiveChatlink('102-asd');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidMissingMapId() {
        new WvWObjectiveChatlink(102);
    }
}

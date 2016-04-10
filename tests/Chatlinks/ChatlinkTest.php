<?php

namespace GW2Treasures\GW2Tools\Tests\Chatlinks;

use GW2Treasures\GW2Tools\Chatlinks\CoinChatlink;
use GW2Treasures\GW2Tools\Chatlinks\MapChatlink;
use GW2Treasures\GW2Tools\Chatlinks\OutfitChatlink;
use GW2Treasures\GW2Tools\Chatlinks\RecipeChatlink;
use GW2Treasures\GW2Tools\Chatlinks\SkillChatlink;
use GW2Treasures\GW2Tools\Chatlinks\SkinChatlink;
use GW2Treasures\GW2Tools\Chatlinks\TextChatlink;
use GW2Treasures\GW2Tools\Chatlinks\TraitChatlink;
use GW2Treasures\GW2Tools\Tests\TestCase;
use GW2Treasures\GW2Tools\Chatlinks\Chatlink;
use GW2Treasures\GW2Tools\Chatlinks\ItemChatlink;

class ChatlinkTest extends TestCase {
    function testDecodeItemChatlink() {
        $chatlink = Chatlink::decode('[&AgEJTQAA]');
        
        $this->assertInstanceOf(ItemChatlink::class, $chatlink,
            "Decoding an item chatlink should return an instance of ItemChatlink");
        $this->assertEquals(Chatlink::TYPE_ITEM, $chatlink->getType(),
            "Decoded item chatlink should have the type item");
    }

    function testDecodeCoinChatlink() {
        $chatlink = Chatlink::decode('[&AQEAAAA=]');

        $this->assertInstanceOf(CoinChatlink::class, $chatlink,
            "Decoding a coin chatlink should return an instance of CoinChatlink");
        $this->assertEquals(Chatlink::TYPE_COIN, $chatlink->getType(),
            "Decoded coin chatlink should have the type coin");
    }

    function testDecodeTextChatlink() {
        $chatlink = Chatlink::decode('[&AwIBAAA=]');

        $this->assertInstanceOf(TextChatlink::class, $chatlink,
            "Decoding a text chatlink should return an instance of TextChatlink");
        $this->assertEquals(Chatlink::TYPE_TEXT, $chatlink->getType(),
            "Decoded text chatlink should have the type text");
    }

    function testDecodeMapChatlink() {
        $chatlink = Chatlink::decode('[&BDgAAAA=]');

        $this->assertInstanceOf(MapChatlink::class, $chatlink,
            "Decoding a map chatlink should return an instance of MapChatlink");
        $this->assertEquals(Chatlink::TYPE_MAP, $chatlink->getType(),
            "Decoded map chatlink should have the type map");
    }

    function testDecodeSkillChatlink() {
        $chatlink = Chatlink::decode('[&B+cCAAA=]');

        $this->assertInstanceOf(SkillChatlink::class, $chatlink,
            "Decoding a skill chatlink should return an instance of SkillChatlink");
        $this->assertEquals(Chatlink::TYPE_SKILL, $chatlink->getType(),
            "Decoded skill chatlink should have the type skill");
    }

    function testDecodeTraitChatlink() {
        $chatlink = Chatlink::decode('[&CPIDAAA=]');

        $this->assertInstanceOf(TraitChatlink::class, $chatlink,
            "Decoding a trait chatlink should return an instance of TraitChatlink");
        $this->assertEquals(Chatlink::TYPE_TRAIT, $chatlink->getType(),
            "Decoded trait chatlink should have the type trait");
    }

    function testDecodeRecipeChatlink() {
        $chatlink = Chatlink::decode('[&CgEAAAA=]');

        $this->assertInstanceOf(RecipeChatlink::class, $chatlink,
            "Decoding a recipe chatlink should return an instance of RecipeChatlink");
        $this->assertEquals(Chatlink::TYPE_RECIPE, $chatlink->getType(),
            "Decoded recipe chatlink should have the type recipe");
    }

    function testDecodeSkinChatlink() {
        $chatlink = Chatlink::decode('[&CwQAAAA=]');

        $this->assertInstanceOf(SkinChatlink::class, $chatlink,
            "Decoding a skin chatlink should return an instance of SkinChatlink");
        $this->assertEquals(Chatlink::TYPE_SKIN, $chatlink->getType(),
            "Decoded skin chatlink should have the type skin");
    }

    function testDecodeOutfitChatlink() {
        $chatlink = Chatlink::decode('[&DAQAAAA=]');

        $this->assertInstanceOf(OutfitChatlink::class, $chatlink,
            "Decoding an outfit chatlink should return an instance of OutfitChatlink");
        $this->assertEquals(Chatlink::TYPE_OUTFIT, $chatlink->getType(),
            "Decoded outfit chatlink should have the type outfit");
    }

    /**
     * @expectedException \GW2Treasures\GW2Tools\Chatlinks\Exceptions\UnknownChatlinkTypeException
     */
    function testDecodeUnknownChatlink() {
        Chatlink::decode('[&0gEJTQAA]');
    }

    /**
     * @expectedException \GW2Treasures\GW2Tools\Chatlinks\Exceptions\ChatlinkFormatException
     */
    function testDecodeMalformedChatlink() {
        Chatlink::decode('not a chatlink');
    }
}

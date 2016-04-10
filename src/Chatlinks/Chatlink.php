<?php

namespace GW2Treasures\GW2Tools\Chatlinks;

use GW2Treasures\GW2Tools\Chatlinks\Exceptions\ChatlinkFormatException;
use GW2Treasures\GW2Tools\Chatlinks\Exceptions\InvalidChatlinkTypeException;
use GW2Treasures\GW2Tools\Chatlinks\Exceptions\UnknownChatlinkTypeException;

abstract class Chatlink {
    const TYPE_COIN = 0x01;
    const TYPE_ITEM = 0x02;
    const TYPE_TEXT = 0x03;
    const TYPE_MAP = 0x04;
    const TYPE_PVP_GAME = 0x05;
    const TYPE_SKILL = 0x06;
    const TYPE_TRAIT = 0x07;
    const TYPE_PLAYER = 0x08;
    const TYPE_RECIPE = 0x09;
    const TYPE_SKIN = 0x0A;
    const TYPE_OUTFIT = 0x0B;
    const TYPE_WVW_OBJECTIVE = 0x0C;

    /**
     *  Decodes a base64 encoded chat code.
     *
     * @param $code
     * @return ChatLink
     * @throws ChatlinkFormatException
     * @throws UnknownChatlinkTypeException
     * @throws \Exception
     */
    public static function decode($code) {
        $data = self::getData($code);

        $chatlinkType = $data[0];

        switch ($chatlinkType) {
            case self::TYPE_ITEM:
                return ItemChatlink::decode($code);
            case self::TYPE_COIN:
                return CoinChatlink::decode($code);
            case self::TYPE_TEXT:
                return TextChatlink::decode($code);
            case self::TYPE_MAP:
                return MapChatlink::decode($code);
            case self::TYPE_SKILL:
                return SkillChatlink::decode($code);
            case self::TYPE_TRAIT:
                return TraitChatlink::decode($code);
            case self::TYPE_RECIPE:
                return RecipeChatlink::decode($code);
            case self::TYPE_SKIN:
                return SkinChatlink::decode($code);
            case self::TYPE_OUTFIT:
                return OutfitChatlink::decode($code);
        }

        throw new UnknownChatlinkTypeException("Unknown chat link type ($chatlinkType)");
    }

    /**
     * Parses base64 encoded chat code and returns byte array.
     *
     * @param string $code
     * @return \int[]
     * @throws ChatlinkFormatException
     */
    protected static function getData($code) {
        if(preg_match('/^\[&([a-z\d+\/]+=*)\]$/i', $code, $matches) !== 1) {
            throw new ChatlinkFormatException("Chatcode does not match the expected format.");
        }

        $base64 = $matches[1];

        $data = [];
        foreach (str_split(base64_decode($base64)) as $char) {
            $data[] = ord($char);
        }

        return $data;
    }

    protected function byteArrayToChatcode(array $data) {
        $chatcode = '';
        foreach ($data as $char) {
            $chatcode .= chr($char);
        }

        return '[&'.base64_encode($chatcode).']';
    }

    public abstract function getType();

    /**
     * @param int $expected
     * @param int $actual
     * @return InvalidChatlinkTypeException
     */
    protected static function invalidChatlinkTypeException($expected, $actual) {
        return new InvalidChatlinkTypeException(
            "Expected a chatcode of type $expected, but got $actual instead. ".
            "Use the generic Chatlink::decode function to decode all types of chatlink."
        );
    }

    protected static function read4Byte($data, &$index) {
        return $data[$index++] << 0x00 | $data[$index++] << 0x08
             | $data[$index++] << 0x10 | $data[$index++] << 0x18;
    }

    protected function write4Byte(&$data, $value) {
        $data[] = ($value >> 0x00) & 0xFF;
        $data[] = ($value >> 0x08) & 0xFF;
        $data[] = ($value >> 0x10) & 0xFF;
        $data[] = ($value >> 0x18) & 0xFF;
    }
}

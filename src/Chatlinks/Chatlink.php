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
    const TYPE_SKILL = 0x07;
    const TYPE_TRAIT = 0x08;
    const TYPE_PLAYER = 0x09;
    const TYPE_RECIPE = 0x0A;
    const TYPE_WARDROBE = 0x0B;
    const TYPE_OUTFIT = 0x0C;

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
}

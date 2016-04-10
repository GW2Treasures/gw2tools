<?php

namespace GW2Treasures\GW2Tools\Chatlinks;

use GW2Treasures\GW2Tools\Chatlinks\Exceptions\ChatlinkFormatException;

abstract class IdChatlink extends Chatlink {
    /** @var int $value */
    protected $value;

    protected static $type;

    public function __construct($value) {
        $this->value = $value;
    }

    public static function decode($code) {
        $data = self::getData($code);

        if ($data[0] !== static::$type) {
            throw self::invalidChatlinkTypeException(static::$type, $data[0]);
        }

        $index = 1;

        $id = self::read4Byte($data, $index);

        if ($index !== count($data)) {
            throw new ChatlinkFormatException('Unknown data in chat code');
        }

        return new static($id);
    }

    public function encode() {
        $data = [$this->getType()];

        $this->write4Byte($data, $this->value);

        return $this->byteArrayToChatcode($data);
    }

    public function getType() {
        return static::$type;
    }
}

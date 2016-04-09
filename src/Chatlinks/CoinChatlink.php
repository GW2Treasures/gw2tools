<?php

namespace GW2Treasures\GW2Tools\Chatlinks;


use GW2Treasures\GW2Tools\Chatlinks\Exceptions\ChatlinkFormatException;

class CoinChatlink extends Chatlink {
    /** @var int $copper */
    protected $copper;

    /**
     * CoinChatlink constructor.
     *
     * @param int $copper
     */
    public function __construct($copper) {
        $this->copper = $copper;
    }

    public static function decode($code) {
        $data = self::getData($code);

        if ($data[0] !== self::TYPE_COIN) {
            throw self::invalidChatlinkTypeException(self::TYPE_COIN, $data[0]);
        }

        $index = 1;

        $copper = self::readCopper($data, $index);

        if ($index !== count($data)) {
            throw new ChatlinkFormatException('Unknown data in chat code');
        }

        return new self($copper);
    }

    /**
     * reads 2-4 bytes of data.
     *
     * @param $data
     * @param $index
     * @return int
     */
    protected static function readCopper($data, &$index) {
        return $data[$index++] << 0x00 | $data[$index++] << 0x08
             | $data[$index++] << 0x10 | $data[$index++] << 0x18;
    }

    public function encode() {
        $data = [$this->getType()];

        $this->writeCopper($data, $this->copper);

        $chatcode = '';
        foreach ($data as $char) {
            $chatcode .= chr($char);
        }

        return '[&'.base64_encode($chatcode).']';
    }

    protected function writeCopper(&$data, $copper) {
        $data[] = ($copper >> 0x00) & 0xFF;
        $data[] = ($copper >> 0x08) & 0xFF;
        $data[] = ($copper >> 0x10) & 0xFF;
        $data[] = ($copper >> 0x18) & 0xFF;
    }

    public function getType() {
        return self::TYPE_COIN;
    }

    public function getCopper() {
        return $this->copper;
    }
}

<?php

namespace GW2Treasures\GW2Tools\Chatlinks;

class CoinChatlink extends IdChatlink {
    protected static $type = self::TYPE_COIN;

    public function __construct($copper) {
        parent::__construct($copper);
    }

    public function getCopper() {
        return $this->value;
    }
}

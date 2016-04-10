<?php

namespace GW2Treasures\GW2Tools\Chatlinks;

class MapChatlink extends IdChatlink {
    protected static $type = self::TYPE_MAP;

    public function getId() {
        return $this->value;
    }
}

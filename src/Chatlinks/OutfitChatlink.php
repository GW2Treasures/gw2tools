<?php

namespace GW2Treasures\GW2Tools\Chatlinks;

class OutfitChatlink extends IdChatlink {
    protected static $type = self::TYPE_OUTFIT;

    public function getId() {
        return $this->value;
    }
}

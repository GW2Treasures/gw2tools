<?php

namespace GW2Treasures\GW2Tools\Chatlinks;

class SkinChatlink extends IdChatlink {
    protected static $type = self::TYPE_SKIN;

    public function getId() {
        return $this->value;
    }
}

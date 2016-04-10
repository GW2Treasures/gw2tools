<?php

namespace GW2Treasures\GW2Tools\Chatlinks;

class TraitChatlink extends IdChatlink {
    protected static $type = self::TYPE_TRAIT;

    public function getId() {
        return $this->value;
    }
}

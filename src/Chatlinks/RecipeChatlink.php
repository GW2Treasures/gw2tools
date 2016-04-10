<?php

namespace GW2Treasures\GW2Tools\Chatlinks;

class RecipeChatlink extends IdChatlink {
    protected static $type = self::TYPE_RECIPE;

    public function getId() {
        return $this->value;
    }
}

<?php

namespace GW2Treasures\GW2Tools\Chatlinks;

class TextChatlink extends IdChatlink {
    protected static $type = self::TYPE_TEXT;

    public function getId() {
        return $this->value;
    }
}

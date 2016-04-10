<?php

namespace GW2Treasures\GW2Tools\Chatlinks;

class SkillChatlink extends IdChatlink {
    protected static $type = self::TYPE_SKILL;

    public function getId() {
        return $this->value;
    }
}

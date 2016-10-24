<?php

namespace GW2Treasures\GW2Tools\Common;

class ItemStack extends APIObject {
    /** @var int $count */
    public $count = 1;

    /** @var int $id */
    public $id = 0;

    /** @var int[] $upgrades */
    public $upgrades = [];

    /** @var int */
    public $skin = null;
}

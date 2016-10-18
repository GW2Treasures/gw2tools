<?php


namespace GW2Treasures\GW2Tools\Common;


class Map extends APIObject {
    /** @var int $id */
    public $id = 0;

    public $continent_id = 0;

    public $default_floor = 0;

    public $map_rect = [];

    public $continent_rect = [];
}

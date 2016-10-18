<?php


namespace GW2Treasures\GW2Tools\Common;


class Continent extends APIObject {
    /** @var int $id */
    public $id = 0;

    public $name = "";

    public $continent_dims = [];

    public $min_zoom = 0;

    public $max_zoom = 0;

    public $floors = [];
}

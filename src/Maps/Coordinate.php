<?php


namespace GW2Treasures\GW2Tools\Maps;


class Coordinate {
    public $x, $y;

    /**
     * Coordinate constructor.
     *
     * @param float $x
     * @param float $y
     */
    public function __construct($x, $y) {
        $this->x = $x;
        $this->y = $y;
    }

    public static function fromArray(array $array) {
        return new Coordinate($array[0], $array[1]);
    }

    public function multiply($x, $y = null) {
        if($y == null) {
            $y = $x;
        }

        return new Coordinate(
            $this->x * $x,
            $this->y * $y
        );
    }

    public function add($x, $y = null) {
        if($y == null) {
            $y = $x;
        }

        return new Coordinate(
            $this->x + $x,
            $this->y + $y
        );
    }

    public function subtract($x, $y = null) {
        if($y == null) {
            $y = $x;
        }

        return new Coordinate(
            $this->x - $x,
            $this->y - $y
        );
    }

    public function floor() {
        return new Coordinate(floor($this->x), floor($this->y));
    }

    public function round() {
        return new Coordinate(round($this->x), round($this->y));
    }

    public function ceil() {
        return new Coordinate(ceil($this->x), ceil($this->y));
    }

    public function distance(Coordinate $other) {
        return sqrt($this->distanceSquared($other));
    }

    public function distanceSquared(Coordinate $other) {
        return pow($this->x - $other->x, 2) + pow($this->y - $other->y, 2);
    }

    public function min(Coordinate $other) {
        return new Coordinate(min($this->x, $other->x), min($this->y, $other->y));
    }

    public function max(Coordinate $other) {
        return new Coordinate(max($this->x, $other->x), max($this->y, $other->y));
    }
}

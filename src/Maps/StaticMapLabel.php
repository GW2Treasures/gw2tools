<?php

namespace GW2Treasures\GW2Tools\Maps;

class StaticMapLabel {
    /** @var string $text */
    private $text;

    /** @var Coordinate $position */
    private $position;

    /** @var bool $hasIcon */
    private $hasIcon;

    /** @var int[] $color */
    private $color;

    /**
     * StaticMapLabel constructor.
     *
     * @param string $text
     * @param Coordinate $position
     * @param int[] $color
     * @param bool $hasIcon
     */
    public function __construct($text, Coordinate $position, $hasIcon = false, $color = [255, 255, 255]) {
        $this->text = $text;
        $this->position = $position;
        $this->hasIcon = $hasIcon;
        $this->color = $color;
    }

    /**
     * @return string
     */
    public function getText() {
        return $this->text;
    }

    /**
     * @return Coordinate
     */
    public function getPosition() {
        return $this->position;
    }

    /**
     * @return boolean
     */
    public function hasIcon() {
        return $this->hasIcon;
    }

    /**
     * @return int[]
     */
    public function getColor() {
        return $this->color;
    }
}

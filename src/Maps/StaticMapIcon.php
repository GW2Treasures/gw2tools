<?php

namespace GW2Treasures\GW2Tools\Maps;

class StaticMapIcon {
    /** @var resource $icon */
    private $icon;

    /** @var Coordinate $position */
    private $position;

    /**
     * StaticMapIcon constructor.
     *
     * @param resource $icon
     * @param Coordinate $position
     */
    public function __construct($icon, Coordinate $position) {
        $this->icon = $icon;
        $this->position = $position;
    }

    public function getIcon() {
        return $this->icon;
    }

    public function getPosition() {
        return $this->position;
    }

    // === STATIC ===

    public static function waypoint(Coordinate $position) {
        $waypoint = new static(null, $position);
        $waypoint->icon = self::getAsset(self::ASSET_WAYPOINT);

        return $waypoint;
    }

    public static function landmark(Coordinate $position) {
        $waypoint = new static(null, $position);
        $waypoint->icon = self::getAsset(self::ASSET_LANDMARK);

        return $waypoint;
    }

    public static function vista(Coordinate $position) {
        $waypoint = new static(null, $position);
        $waypoint->icon = self::getAsset(self::ASSET_VISTA);

        return $waypoint;
    }

    /** @var resource[] $assets */
    private static $_assets = [];

    const ASSET_WAYPOINT = 'waypoint';
    const ASSET_LANDMARK = 'landmark';
    const ASSET_VISTA = 'vista';

    /**
     * @param string $asset
     * @return resource
     */
    private static function getAsset($asset) {
        if(!array_key_exists($asset, self::$_assets)) {
            self::$_assets[$asset] = imagecreatefrompng(__DIR__.'/assets/'.$asset.'.png');
        }

        return self::$_assets[$asset];
    }
}

<?php

namespace GW2Treasures\GW2Tools\Maps;


use GW2Treasures\GW2Tools\Common\Continent;
use GW2Treasures\GW2Tools\Common\Map;

class StaticMap {
    /** @var Continent continentId */
    protected $continent;

    /** @var int floor */
    protected $floor;

    /** @var Coordinate $nwCorner */
    protected $nwCorner;

    /** @var Coordinate $seCorner */
    protected $seCorner;

    /** @var string $cachePath */
    protected $cachePath;

    /** @var StaticMapIcon[] $icons */
    protected $icons = [];

    /** @var StaticMapLabel[] $labels */
    protected $labels = [];

    /**
     * StaticMap constructor.
     *
     * @param Continent $continent
     * @param int $floor
     * @throws \Exception
     */
    public function __construct(Continent $continent, $floor) {
        if(!in_array($floor, $continent->floors)) {
            throw new \Exception("Floor $floor is not a valid floor of {$continent->name}.");
        }

        $this->continent = $continent;
        $this->floor = $floor;

        $this->setCachePath('./_mapcache');
    }

    /**
     * Sets the bounding rectangle of the map.
     *
     * @param Coordinate $nwCorner
     * @param Coordinate $seCorner
     */
    public function setBounds(Coordinate $nwCorner, Coordinate $seCorner) {
        if($nwCorner->x < 0 || $nwCorner->y < 0 || $seCorner->x > $this->continent->continent_dims[0] || $seCorner->y > $this->continent->continent_dims[1]) {
            throw new \InvalidArgumentException("The map bounds are not within the continent dimensions.");
        }

        $this->nwCorner = $nwCorner;
        $this->seCorner = $seCorner;
    }

    public function addWaypoint(Coordinate $position, $label) {
        $this->addLabel(new StaticMapLabel($label, $position, true));
        $this->addIcon(StaticMapIcon::waypoint($position));
    }

    public function addLandmark(Coordinate $position, $label) {
        $this->addLabel(new StaticMapLabel($label, $position, true));
        $this->addIcon(StaticMapIcon::landmark($position));
    }

    public function addVista(Coordinate $position) {
        $this->addIcon(StaticMapIcon::vista($position));
    }

    public function addIcon(StaticMapIcon $icon) {
        $this->icons[] = $icon;
    }

    public function addLabel(StaticMapLabel $label) {
        $this->labels[] = $label;
    }

    /**
     * Converts world coordinates to tile coordinates
     *
     * @param Coordinate $coordinate
     * @param int $zoom
     * @return Coordinate
     */
    protected function getTileCoordinatesOf(Coordinate $coordinate, $zoom) {
        $tileCount = 1 << $zoom;

        return new Coordinate(
            floor($coordinate->x / ($this->continent->continent_dims[0] / $tileCount)),
            floor($coordinate->y / ($this->continent->continent_dims[1] / $tileCount))
        );
    }

    public function setCachePath($path) {
        $this->cachePath = realpath($path);
    }

    public function getCachePath() {
        return $this->cachePath;
    }

    protected function getTile($x, $y, $zoom) {
        $cachePath = $this->getCachePath();
        $url = "https://tiles.guildwars2.com/{$this->continent->id}/{$this->floor}/$zoom/$x/$y.jpg";
        $cacheFileName = $cachePath."/{$this->continent->id}-{$this->floor}-$x-$y-$zoom.jpg";

        if($cachePath === false) {
            return imagecreatefromjpeg($url);
        }

        if(!file_exists($cacheFileName)) {
            $file = file_get_contents($url);
            file_put_contents($cacheFileName, $file);

            return imagecreatefromstring($file);
        }

        return imagecreatefromjpeg($cacheFileName);
    }

    /**
     * @param int $width
     * @param int $height
     * @param int $scale
     *
     * @return resource
     */
    public function render($width, $height, $scale) {
        if($width <= 0 || $height <= 0 || $scale <= 0) {
            throw new \InvalidArgumentException("Parameters for render have to be positive.");
        }

        // always use max_zoom
        $zoom = $this->continent->max_zoom;

        $continentSize = new Coordinate($this->continent->continent_dims[0], $this->continent->continent_dims[1]);
        $tileCount = 1 << $zoom;
        $tileSize = $continentSize->x / $tileCount;

        // get the tiles of the north-west and south-east corner
        $tileNW = $this->getTileCoordinatesOf($this->nwCorner, $zoom);
        $tileSE = $this->getTileCoordinatesOf($this->seCorner, $zoom);

        // calculate how many tiles we are displaying
        $tileCountX = $tileSE->x - $tileNW->x + 1;
        $tileCountY = $tileSE->y - $tileNW->y + 1;

        // create a temp image buffer that gets resized later
        // this prevents seems beetween tiles but uses a lot of memory if there are to many tiles…
        $buffer = imagecreatetruecolor($tileCountX * 256, $tileCountY * 256);

        // load all tiles
        // TODO: parallel loading
        for($x = $tileNW->x; $x <= $tileSE->x; $x++) {
            for($y = $tileNW->y; $y <= $tileSE->y; $y++) {
                $tile = $this->getTile($x, $y, $zoom);

                // render the tile in the buffer
                imagecopy($buffer, $tile, ($x - $tileNW->x) * 256, ($y - $tileNW->y) * 256, 0, 0, 256, 256);
                imagedestroy($tile);
                unset($tile);
            }
        }

        // get the world coordinates of the nw corner of the nw tile
        $tileNWWorld = new Coordinate(
            $tileSize * $tileNW->x,
            $tileSize * $tileNW->y
        );

        // get the world coordinates of the sw corner of the sw tile
        $tileSEWorld = new Coordinate(
            $tileSize * $tileSE->x + $tileSize,
            $tileSize * $tileSE->y + $tileSize
        );

        // get the size in world coordinates of the rendered buffer
        $renderedSize = new Coordinate(
            $tileSEWorld->x - $tileNWWorld->x,
            $tileSEWorld->y - $tileNWWorld->y
        );

        // get the position of the NW corner of the requested bounds within the buffer
        $rectMin = new Coordinate(
            ($this->nwCorner->x - $tileNWWorld->x) / $renderedSize->x,
            ($this->nwCorner->y - $tileNWWorld->y) / $renderedSize->y
        );

        // get the position of the SW corner of the requested bounds within the buffer
        $rectMax = new Coordinate(
            ($this->seCorner->x - $tileNWWorld->x) / $renderedSize->x,
            ($this->seCorner->y - $tileNWWorld->y) / $renderedSize->y
        );


        // get the aspect ration of the map bounds and the size of the image
        $aspectRatio = $width / $height;
        $mapAspectRatio = ($this->seCorner->x - $this->nwCorner->x) / ($this->seCorner->y - $this->nwCorner->y);

        // resize the image if needed
        // TODO: adjust the bounds of rendered map instead? Always return exactly the requested image size…
        if($aspectRatio < $mapAspectRatio) {
            $width = ceil($height * $mapAspectRatio);
        } else {
            $height = ceil($width * (1 / $mapAspectRatio));
        }

        // create the image
        $image = imagecreatetruecolor($width * $scale, $height * $scale);
        $white = imagecolorallocate($buffer, 255, 255, 255);
        $black = imagecolorallocate($buffer, 0, 0, 0);

        // copy the buffer into the image
        imagecopyresampled($image, $buffer,
            // destination position
            0, 0,
            // source position
            $rectMin->x * $tileCountX * 256, $rectMin->y * $tileCountY * 256,
            // destination size
            $width * $scale, $height * $scale,
            // source size
            ($rectMax->x - $rectMin->x) * $tileCountX * 256, ($rectMax->y - $rectMin->y) * $tileCountY * 256
        );
        imagedestroy($buffer);
        unset($buffer);

        // render icons
        foreach($this->icons as $icon) {
            $this->renderIcon($image, $icon, $width, $height, $scale);
        }

        // render labels
        foreach($this->labels as $label) {
            $this->renderLabel($image, $label, $width, $height, $scale);
        }

        return $image;
    }

    protected function renderIcon(&$image, StaticMapIcon $icon, $width, $height, $scale) {
        $position = $this->worldCoordinateToBoundary($icon->getPosition())
            ->multiply($width * $scale, $height * $scale)->round();

        $img = $icon->getIcon();

        imagecopyresampled($image, $img, $position->x - 8 * $scale, $position->y - 8 * $scale, 0, 0, 16 * $scale, 16 * $scale, imagesx($img), imagesy($img));
    }

    protected function renderLabel(&$image, StaticMapLabel $label, $width, $height, $scale) {
        $fontFile = __DIR__.'/assets/menomonia.ttf';
        $color = $label->getColor();
        $color = imagecolorallocate($image, $color[0], $color[1], $color[2]);
        $shadow = imagecolorallocate($image, 0, 0, 0);
        $text = $label->getText();

        $fontSize = 10 * ($scale * 0.75 + 0.25);
        $textSize = imagettfbbox($fontSize, 0, $fontFile, $text);
        $textWidth = $textSize[2] - $textSize[0];
        $textHeight = $textSize[3] - $textSize[1];

        $imageWidth = $width * $scale;
        $imageHeight = $height * $scale;

        $position = $this->worldCoordinateToBoundary($label->getPosition())
            ->multiply($width * $scale, $height * $scale)->round();

        $x = min(max(8 * $scale, $position->x - $textWidth / 2), $imageWidth - 8 * $scale - $textWidth);
        $y = min(max($textHeight + 8 * $scale, $position->y + $textHeight + 18 * $scale), $imageHeight - 8 * $scale);

        imagettftext($image, $fontSize, 0, $x + 1, $y + 0, $shadow, $fontFile, $text);
        imagettftext($image, $fontSize, 0, $x - 1, $y + 0, $shadow, $fontFile, $text);
        imagettftext($image, $fontSize, 0, $x + 0, $y + 1, $shadow, $fontFile, $text);
        imagettftext($image, $fontSize, 0, $x + 0, $y - 1, $shadow, $fontFile, $text);

        imagettftext($image, $fontSize, 0, $x + 1, $y + 1, $shadow, $fontFile, $text);
        imagettftext($image, $fontSize, 0, $x + 1, $y - 1, $shadow, $fontFile, $text);
        imagettftext($image, $fontSize, 0, $x - 1, $y + 1, $shadow, $fontFile, $text);
        imagettftext($image, $fontSize, 0, $x - 1, $y - 1, $shadow, $fontFile, $text);

        imagettftext($image, $fontSize, 0, $x + 0, $y + 0, $color, $fontFile, $text);
    }

    public function worldCoordinateToBoundary(Coordinate $coordinate) {
        return new Coordinate(
            ($coordinate->x - $this->nwCorner->x) / ($this->seCorner->x - $this->nwCorner->x),
            ($coordinate->y - $this->nwCorner->y) / ($this->seCorner->y - $this->nwCorner->y)
        );
    }

    public static function mapCoordinateToContinent(Coordinate $coordinate, Map $map) {
        $continentMin = Coordinate::fromArray($map->continent_rect[0]);
        $continentMax = Coordinate::fromArray($map->continent_rect[1]);

        $mapMin = Coordinate::fromArray($map->map_rect[0]);
        $mapMax = Coordinate::fromArray($map->map_rect[1]);

        return new Coordinate(
            $continentMin->x + ($continentMax->x - $continentMin->x) * (($coordinate->x - $mapMin->x) / ($mapMax->x - $mapMin->x)),
            $continentMin->y + ($continentMax->y - $continentMin->y) * (($coordinate->y - $mapMin->y) / ($mapMax->y - $mapMin->y))
        );
    }
}

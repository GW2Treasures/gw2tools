<?php


namespace GW2Treasures\GW2Tools\Common;


class APIObject {
    public static function fromObject(\stdClass $object) {
        $itemStack = new static();

        foreach ($object as $property => &$value) {
            $itemStack->{$property} = $value;
        }

        return $itemStack;
    }

    public static function fromArray(array $array) {
        $itemStack = new static();

        foreach ($array as $property => &$value) {
            $itemStack->{$property} = $value;
        }

        return $itemStack;
    }
}

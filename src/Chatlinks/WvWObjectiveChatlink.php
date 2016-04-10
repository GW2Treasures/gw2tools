<?php

namespace GW2Treasures\GW2Tools\Chatlinks;

use GW2Treasures\GW2Tools\Chatlinks\Exceptions\ChatlinkFormatException;

class WvWObjectiveChatlink extends Chatlink {
    /** @var int $objectiveId */
    protected $objectiveId;

    /** @var int $mapId */
    protected $mapId;

    /**
     * WvWObjectiveChatlink constructor.
     *
     * @param string|int $objectiveId
     * @param int|null $mapId
     */
    public function __construct($objectiveId, $mapId = null) {
        if(is_int($objectiveId) && $mapId !== null && is_int($mapId)) {
            $this->objectiveId = $objectiveId;
            $this->mapId = $mapId;
        } elseif(is_string($objectiveId)) {
            if(preg_match('/^([\d]+)-([\d]+)$/', $objectiveId, $matches)) {
                $this->objectiveId = (int)$matches[2];
                $this->mapId = (int)$matches[1];
            } else {
                throw new \InvalidArgumentException('The string id has to have the format [int]-[int]');
            }
        } else {
            throw new \InvalidArgumentException(
                'WvWObjectiveChatlink::__construct can be called with 2 int ids or 1 string id.'
            );
        }
    }

    public static function decode($code) {
        $data = self::getData($code);

        if ($data[0] !== self::TYPE_WVW_OBJECTIVE) {
            throw self::invalidChatlinkTypeException(self::TYPE_WVW_OBJECTIVE, $data[0]);
        }

        $index = 1;

        $objectiveId = self::read4Byte($data, $index);
        $mapId = self::read4Byte($data, $index);

        if ($index !== count($data)) {
            throw new ChatlinkFormatException('Unknown data in chat code');
        }

        return new static($objectiveId, $mapId);
    }

    public function encode() {
        $data = [$this->getType()];

        $this->write4Byte($data, $this->objectiveId);
        $this->write4Byte($data, $this->mapId);

        return $this->byteArrayToChatcode($data);
    }

    public function getType() {
        return self::TYPE_WVW_OBJECTIVE;
    }

    public function getId() {
        return $this->getMapId().'-'.$this->getObjectiveId();
    }

    public function getObjectiveId() {
        return $this->objectiveId;
    }

    public function getMapId() {
        return $this->mapId;
    }
}

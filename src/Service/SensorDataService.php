<?php

namespace App\Service;

use App\Entity\SensorData;

class SensorDataService
{
    public const ACTIVE_BIN_SEQ = "1";
    public const DEACTIVE_BIN_SEQ = "0";

    public function analyse(array $sensorDatas, \DateTime $start, \DateTime $end): array
    {
        $dataFilteredWithDates = [];

        /** @var SensorData $sensorData */
        foreach ($sensorDatas as $sensorData) {
            $dateSensorData = (new \DateTime())->setTimestamp($sensorData->getTimestamp());

            if ($dateSensorData >= $start && $dateSensorData <= $end) {
                $dataFilteredWithDates[] = $sensorData;
            }
        }

        

    }

    public function analyseAndExcludeDetectionBinSeq(SensorData $sensorData): bool
    {
        $detectionBinSeq = $sensorData->getDetectionBinSeq();

        $maxLength = strlen($detectionBinSeq);

        $countActiveMessage = 0;
        $countDeactiveMessage = 0;

        for($i=0;$i<=$maxLength;$i++) {
            if (substr($detectionBinSeq, $i, 1) === self::ACTIVE_BIN_SEQ) {
                $countActiveMessage += 1;
            } else if (substr($detectionBinSeq, $i, 1) === self::DEACTIVE_BIN_SEQ) {
                $countDeactiveMessage += 1;
            }
        }

        if ($_ENV['ACTIVE_BIN_SEQ_NUMBER'] >= $countActiveMessage) {
            return false;
        }

        return true;
    }
}

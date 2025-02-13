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

        //initialized variables
        $occupancyStatus = null;
        $usageDuration = 0;
        $countOccupancyTrue = 0;
        $peakUsageTimes = [];
        $underUtilizedhours = null;
        $temperatureSum = 0;
        $ligtLevelSum = 0;

        /** @var SensorData $dataFilteredWithDate */
        foreach ($dataFilteredWithDates as $dataFilteredWithDate) {
            if ($this->analyseAndExcludeDetectionBinSeq($dataFilteredWithDate)) {
                $occupancyStatus = 0;
                $underUtilizedhours += 600;
            } else {
                $occupancyStatus = 1;
                $countOccupancyTrue ++;

                $date = (new \DateTime())->setTimestamp($dataFilteredWithDate->getTimestamp());

                if (!array_key_exists($date->format("H"), $peakUsageTimes)) {
                    $peakUsageTimes[$date->format("H")] = 0;
                }

                $peakUsageTimes[$date->format("H")] ++;
            }

            $temperatureSum += $dataFilteredWithDate->getTemp();
            $usageDuration += 600;
            $ligtLevelSum += $dataFilteredWithDate->getLightLevel();
        }

        asort($peakUsageTimes);

        return [
            "occupancyStatus" => $occupancyStatus,
            "usageDuration" => $usageDuration,
            "averageOccupancyRate" =>$countOccupancyTrue / count($dataFilteredWithDates),
            "peakUsageTime" => array_key_first($peakUsageTimes),
            "underUtilizedHours" => $underUtilizedhours / 3600,
            "tempAvg" => $temperatureSum / count($dataFilteredWithDates),
            "humAvg" => 0,
            "exportTimestamp" => time(),
            "lightLevelAvg" => $ligtLevelSum / count($dataFilteredWithDates),
            "noiseLevelAvg" => 0
        ];
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

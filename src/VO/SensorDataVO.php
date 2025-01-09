<?php

namespace App\VO;

class SensorDataVO
{
    public ?int $occupancyStatus = null;
    public ?int $usageDuration = null;
    public ?int $averageOccupancyRate = null;
    public ?int $peakUsageTime = null;
    public ?int $underutilizedHours = null;

    public ?float $environnmentTemperature = null;
    public ?float $environnmentHumidity = null;
    public ?float $lightLevel = null;
    public ?float $noiseLevel = null;
    public string $deviceStatus;

}

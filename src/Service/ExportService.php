<?php

namespace App\Service;
use App\Entity\Organization;
use App\Entity\Sensor;
use App\Repository\SensorRepository;

class ExportService
{
    public function __construct(
        private readonly SensorDataService $sensorDataService
    ) {
    }

    public function export(Organization $organization, \DateTime $start, \DateTime $end)
    {
        $sensors = $organization->getSensors();
        $exportData = [];

        /** @var Sensor $sensor */
        foreach ($sensors as $sensor) {
            $dataAnalyzed = $this->sensorDataService->analyse($sensor->getSensorData()->toArray(), $start, $end);

            $exportData[] = [
                $sensor->getDeviceId(),
                $sensor->getDeviceType(),
                $sensor->getSiteName(),
                $sensor->getBuildingName(),
                $sensor->getFloorNumber(),
                $sensor->getWorkplaceId(),
                time(),
                $dataAnalyzed["occupancyStatus"],
                $dataAnalyzed["usageDuration"],
                $dataAnalyzed["averageOccupancyRate"],
                $dataAnalyzed["peakUsageTime"],
                $dataAnalyzed["underUtilizedHours"],
                $dataAnalyzed["tempAvg"],
                $dataAnalyzed["humAvg"],
                $dataAnalyzed["lightLevelAvg"],
                $dataAnalyzed["noiseLevelAvg"],
                $sensor->getInstallationDate()->format("Y-m-d H:i:s"),
                1,
                $dataAnalyzed["exportTimestamp"]
            ];
        }

        return $exportData;
    }

    public function exportHeaders(): array
    {
        return [
            "Device Id",
            "Device Type",
            "Site name",
            "Building Name",
            "Floor Number",
            "WorkPlace Id",
            "Timestamp",
            "Occupancy Status",
            "Usage duration",
            "Average Occupancy Rate",
            "Peak Usage Time",
            "Underutilized Hours",
            "Environnment temperature avrage",
            "Environnment humidity average",
            "Light level average",
            "Noise level average",
            "Installation date",
            "Device status",
            "Export timestamp"
        ];
    }
}

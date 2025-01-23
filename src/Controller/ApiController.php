<?php

namespace App\Controller;

use App\Entity\ApiCredentials;
use App\Entity\Sensor;
use App\Entity\SensorData;
use App\Service\LoggerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

class ApiController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly LoggerService $loggerService
    ) {
    }

    #[Route('/api/callback', name: 'app_api_callback', methods: ['POST'])]
    public function callback(Request $request): Response
    {
        $apiKey = $request->query->get('apiKey');

        $this->loggerService->saveLog("Api authentication", "APIKEY : " . $apiKey);

        $apiCredentialsRepository = $this->entityManager->getRepository(ApiCredentials::class);
        $apiCredentials = $apiCredentialsRepository->findOneBy([
            'uuid' => $apiKey
        ]);

        if ($apiCredentials instanceof ApiCredentials) {
            $this->loggerService->saveLog("Api authentication success", "");
            $this->loggerService->saveLog("Api payload content", json_encode($request->getContent()));

            $data = json_decode($request->getContent(), true);

            try {
                if ($data['frame_type'] === "PIR_SETUP") {
                    $sensorData = $this->mapPayloadPirSetup($data);

                    $this->entityManager->persist($sensorData);
                    $this->entityManager->flush();
                } elseif ($data['frame_type'] === "DETECTED_MOVEMENT") {
                    $sensorData = $this->mapPayloadDetectedMovement($data);

                    $this->entityManager->persist($sensorData);
                    $this->entityManager->flush();
                } elseif ($data['frame_type'] === "NO_MOVEMENT_INIT") {
                    $sensorData = $this->mapPayloaNoMovementInit($data);

                    $this->entityManager->persist($sensorData);
                    $this->entityManager->flush();
                } elseif ($data['frame_type'] === "NO_MOVEMENT") {
                    $sensorData = $this->mapPayloadNoMovement($data);

                    $this->entityManager->persist($sensorData);
                    $this->entityManager->flush();
                }

                $this->loggerService->saveLog("Api code successfull", "");

            } catch (\Exception $exception) {
                $this->loggerService->saveLog("Api code error", $exception->getMessage());
            }

            return $this->json([
                'message' => "Success"
            ]);
        }

        $this->loggerService->saveLog("Api authentication failure", "");

        return $this->json([
            'message' => "Api key must be valid"
        ], 400);
    }

    private function mapPayloadNoMovement(array $data): SensorData
    {
        $sensorRepository = $this->entityManager->getRepository(Sensor::class);
        $sensor = $sensorRepository->findOneBy([
            'deviceId' => $data['deviceId']
        ]);

        if ($sensor === null) {
            throw new NotFoundHttpException("Sensor not found");
        }

        $sensorData = new SensorData();
        $sensorData->setSensor($sensor)
            ->setTimestamp((int) $data['timestamp'])
            ->setClientName($data['client_name'])
            ->setMvtMessageCounter($data['dwt_message_oounter'])
            ->setBlockCounter($data['block_oounter'])
            ->setPayloadType($data['payload_type'])
            ->setFrameType($data['frame_type'])
            ->setTemp($data['temp'])
            ->setBattery($data['battery'])
            ->setLowBatteryhreshold($data['low_battery_threshold'])
            ->setXPir($data['X_PIR'])
            ->setYPir($data['Y_PIR'])
            ->setZpir($data['Z_PIR'])
            ->setPirLength($data['PIR_length'])
            ->setPirSens($data['PIR_sens'])
            ->setLightLevel($data['light_level'])
            ->setTempdLedBlink($data['temp_led_blink'])
            ->setLedStatus($data['led_status'])
            ->setSleepMode($data['sleep_mode'])
            ->setKeepaliveInterval($data['keepalive_interval']);

        return $sensorData;
    }

    private function mapPayloadPirSetup(array $data): SensorData
    {
        $sensorRepository = $this->entityManager->getRepository(Sensor::class);
        $sensor = $sensorRepository->findOneBy([
            'deviceId' => $data['deviceId']
        ]);

        if ($sensor === null) {
            throw new NotFoundHttpException("Sensor not found");
        }

        $sensorData = new SensorData();
        $sensorData->setSensor($sensor)
            ->setTimestamp((int) $data['timestamp'])
            ->setClientName($data['client_name'])
            ->setMvtMessageCounter($data['dwt_message_oounter'])
            ->setBlockCounter($data['block_oounter'])
            ->setPayloadType($data['payload_type'])
            ->setFrameType($data['frame_type'])
            ->setTemp($data['temp'])
            ->setBattery($data['battery'])
            ->setLowBatteryhreshold($data['low_battery_threshold'])
            ->setXPir($data['X_PIR'])
            ->setYPir($data['Y_PIR'])
            ->setZpir($data['Z_PIR'])
            ->setPirLength($data['PIR_length'])
            ->setPirSens($data['PIR_sens'])
            ->setLightLevel($data['light_level'])
            ->setTempdLedBlink($data['temp_led_blink'])
            ->setLedStatus($data['led_status'])
            ->setSleepMode($data['sleep_mode'])
            ->setKeepaliveInterval($data['keepalive_interval']);

        return $sensorData;
    }

    private function mapPayloadDetectedMovement(array $data): SensorData
    {
        $sensorRepository = $this->entityManager->getRepository(Sensor::class);
        $sensor = $sensorRepository->findOneBy([
            'deviceId' => $data['deviceId']
        ]);

        if ($sensor === null) {
            throw new NotFoundHttpException("Sensor not found");
        }

        $sensorData = new SensorData();
        $sensorData->setSensor($sensor)
            ->setTimestamp((int) $data['timestamp'])
            ->setClientName($data['client_name'])
            ->setMvtMessageCounter($data['dwt_message_oounter'])
            ->setBlockCounter($data['block_oounter'])
            ->setPayloadType($data['payload_type'])
            ->setFrameType($data['frame_type'])
            ->setTemp($data['temp'])
            ->setDetectionBinSeq($data['detection_bin_seq'])
            ->setDwinit($data['dw_init'])
            ->setDwInter($data['dw_inter'])
            ->setDwEnd($data['dw_end'])
            ->setLightLevel($data['ligth_level']);

        return $sensorData;
    }

    private function mapPayloaNoMovementInit(array $data): SensorData
    {
        $sensorRepository = $this->entityManager->getRepository(Sensor::class);
        $sensor = $sensorRepository->findOneBy([
            'deviceId' => $data['deviceId']
        ]);

        if ($sensor === null) {
            throw new NotFoundHttpException("Sensor not found");
        }

        $sensorData = new SensorData();
        $sensorData->setSensor($sensor)
            ->setTimestamp((int) $data['timestamp'])
            ->setClientName($data['client_name'])
            ->setMvtMessageCounter($data['dwt_message_oounter'])
            ->setBlockCounter($data['block_oounter'])
            ->setPayloadType($data['payload_type'])
            ->setFrameType($data['frame_type'])
            ->setTemp($data['temp'])
            ->setDetectionBinSeq($data['detection_bin_seq'])
            ->setDwinit($data['dw_init'])
            ->setDwInter($data['dw_inter'])
            ->setDwEnd($data['dw_end'])
            ->setLightLevel($data['ligth_level'])
            ->setPrevDwinit($data['prev_dw_init'])
            ->setPrevDwIntra($data['prev_dw_intra'])
            ->setPrevDwEnd($data['prev_dw_end']);

        return $sensorData;
    }
}

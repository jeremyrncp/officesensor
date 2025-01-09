<?php

namespace App\Entity;

use App\Repository\SensorDataRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SensorDataRepository::class)]
class SensorData
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[ORM\ManyToOne(inversedBy: 'sensorData')]
    private ?Sensor $sensor = null;
    #[ORM\Column(nullable: true)]
    private ?int $timestamp = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $clientName = null;

    #[ORM\Column(nullable: true)]
    private ?int $mvtMessageCounter = null;

    #[ORM\Column(nullable: true)]
    private ?int $blockCounter = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $payloadType = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $frameType = null;

    #[ORM\Column(nullable: true)]
    private ?string $temp = null;

    #[ORM\Column(nullable: true)]
    private ?float $battery = null;

    #[ORM\Column(nullable: true)]
    private ?float $lowBatteryhreshold = null;

    #[ORM\Column(nullable: true)]
    private ?int $XPir = null;

    #[ORM\Column(nullable: true)]
    private ?int $YPir = null;

    #[ORM\Column(nullable: true)]
    private ?int $ZPir = null;

    #[ORM\Column(nullable: true)]
    private ?int $PirLength = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $PirSens = null;

    #[ORM\Column(nullable: true)]
    private ?float $lightLevel = null;

    #[ORM\Column(nullable: true)]
    private ?int $tempdLedBlink = null;

    #[ORM\Column(nullable: true)]
    private ?int $ledStatus = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sleepMode = null;

    #[ORM\Column(nullable: true)]
    private ?int $keepaliveInterval = null;

    #[ORM\Column(length: 60, nullable: true)]
    private ?string $detectionBinSeq = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $dwinit = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $dwInter = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $dwEnd = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $prevDwinit = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $prevDwIntra = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $prevDwEnd = null;

    public function getClientName(): ?string
    {
        return $this->clientName;
    }

    public function setClientName(?string $clientName): static
    {
        $this->clientName = $clientName;

        return $this;
    }

    public function getMvtMessageCounter(): ?int
    {
        return $this->mvtMessageCounter;
    }

    public function setMvtMessageCounter(?int $mvtMessageCounter): static
    {
        $this->mvtMessageCounter = $mvtMessageCounter;

        return $this;
    }

    public function getBlockCounter(): ?int
    {
        return $this->blockCounter;
    }

    public function setBlockCounter(?int $blockCounter): static
    {
        $this->blockCounter = $blockCounter;

        return $this;
    }

    public function getPayloadType(): ?string
    {
        return $this->payloadType;
    }

    public function setPayloadType(?string $payloadType): static
    {
        $this->payloadType = $payloadType;

        return $this;
    }

    public function getFrameType(): ?string
    {
        return $this->frameType;
    }

    public function setFrameType(?string $frameType): static
    {
        $this->frameType = $frameType;

        return $this;
    }

    public function getTemp(): ?string
    {
        return $this->temp;
    }

    public function setTemp(?string $temp): static
    {
        $this->temp = $temp;

        return $this;
    }

    public function getBattery(): ?float
    {
        return $this->battery;
    }

    public function setBattery(?float $battery): static
    {
        $this->battery = $battery;

        return $this;
    }

    public function getLowBatteryhreshold(): ?float
    {
        return $this->lowBatteryhreshold;
    }

    public function setLowBatteryhreshold(?float $lowBatteryhreshold): static
    {
        $this->lowBatteryhreshold = $lowBatteryhreshold;

        return $this;
    }

    public function getXPir(): ?int
    {
        return $this->XPir;
    }

    public function setXPir(?int $XPir): static
    {
        $this->XPir = $XPir;

        return $this;
    }

    public function getYPir(): ?int
    {
        return $this->YPir;
    }

    public function setYPir(?int $YPir): static
    {
        $this->YPir = $YPir;

        return $this;
    }

    public function getZPir(): ?int
    {
        return $this->ZPir;
    }

    public function setZPir(?int $ZPir): static
    {
        $this->ZPir = $ZPir;

        return $this;
    }

    public function getPirLength(): ?int
    {
        return $this->PirLength;
    }

    public function setPirLength(?int $PirLength): static
    {
        $this->PirLength = $PirLength;

        return $this;
    }

    public function getPirSens(): ?string
    {
        return $this->PirSens;
    }

    public function setPirSens(?string $PirSens): static
    {
        $this->PirSens = $PirSens;

        return $this;
    }

    public function getLightLevel(): ?float
    {
        return $this->lightLevel;
    }

    public function setLightLevel(?float $lightLevel): static
    {
        $this->lightLevel = $lightLevel;

        return $this;
    }

    public function getTempdLedBlink(): ?int
    {
        return $this->tempdLedBlink;
    }

    public function setTempdLedBlink(?int $tempdLedBlink): static
    {
        $this->tempdLedBlink = $tempdLedBlink;

        return $this;
    }

    public function getLedStatus(): ?int
    {
        return $this->ledStatus;
    }

    public function setLedStatus(?int $ledStatus): static
    {
        $this->ledStatus = $ledStatus;

        return $this;
    }

    public function getSleepMode(): ?string
    {
        return $this->sleepMode;
    }

    public function setSleepMode(?string $sleepMode): static
    {
        $this->sleepMode = $sleepMode;

        return $this;
    }

    public function getKeepaliveInterval(): ?int
    {
        return $this->keepaliveInterval;
    }

    public function setKeepaliveInterval(?int $keepaliveInterval): static
    {
        $this->keepaliveInterval = $keepaliveInterval;

        return $this;
    }

    public function getDetectionBinSeq(): ?string
    {
        return $this->detectionBinSeq;
    }

    public function setDetectionBinSeq(?string $detectionBinSeq): static
    {
        $this->detectionBinSeq = $detectionBinSeq;

        return $this;
    }

    public function getDwinit(): ?string
    {
        return $this->dwinit;
    }

    public function setDwinit(?string $dwinit): static
    {
        $this->dwinit = $dwinit;

        return $this;
    }

    public function getDwInter(): ?string
    {
        return $this->dwInter;
    }

    public function setDwInter(?string $dwInter): static
    {
        $this->dwInter = $dwInter;

        return $this;
    }

    public function getDwEnd(): ?string
    {
        return $this->dwEnd;
    }

    public function setDwEnd(?string $dwEnd): static
    {
        $this->dwEnd = $dwEnd;

        return $this;
    }

    public function getPrevDwinit(): ?string
    {
        return $this->prevDwinit;
    }

    public function setPrevDwinit(?string $prevDwinit): static
    {
        $this->prevDwinit = $prevDwinit;

        return $this;
    }

    public function getPrevDwIntra(): ?string
    {
        return $this->prevDwIntra;
    }

    public function setPrevDwIntra(?string $prevDwIntra): static
    {
        $this->prevDwIntra = $prevDwIntra;

        return $this;
    }

    public function getPrevDwEnd(): ?string
    {
        return $this->prevDwEnd;
    }

    public function setPrevDwEnd(?string $prevDwEnd): static
    {
        $this->prevDwEnd = $prevDwEnd;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getSensor(): ?Sensor
    {
        return $this->sensor;
    }

    public function setSensor(?Sensor $sensor): static
    {
        $this->sensor = $sensor;

        return $this;
    }

    public function getTimestamp(): ?int
    {
        return $this->timestamp;
    }

    public function setTimestamp(?int $timestamp): static
    {
        $this->timestamp = $timestamp;

        return $this;
    }
}

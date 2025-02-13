<?php

namespace App\Entity;

use App\Repository\SensorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SensorRepository::class)]
class Sensor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $deviceId = null;

    #[ORM\Column(length: 255)]
    private ?string $deviceType = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $siteName = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $buildingName = null;

    #[ORM\Column(nullable: true)]
    private ?int $floorNumber = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $workplaceId = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $installationDate = null;

    /**
     * @var Collection<int, SensorData>
     */
    #[ORM\OneToMany(targetEntity: SensorData::class, mappedBy: 'sensor')]
    private Collection $sensorData;

    #[ORM\ManyToOne(inversedBy: 'sensors')]
    private ?Organization $organization = null;

    public function __construct()
    {
        $this->sensorData = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDeviceId(): ?string
    {
        return $this->deviceId;
    }

    public function setDeviceId(?string $deviceId): static
    {
        $this->deviceId = $deviceId;

        return $this;
    }

    public function getDeviceType(): ?string
    {
        return $this->deviceType;
    }

    public function setDeviceType(string $deviceType): static
    {
        $this->deviceType = $deviceType;

        return $this;
    }

    public function getSiteName(): ?string
    {
        return $this->siteName;
    }

    public function setSiteName(?string $siteName): static
    {
        $this->siteName = $siteName;

        return $this;
    }

    public function getBuildingName(): ?string
    {
        return $this->buildingName;
    }

    public function setBuildingName(?string $buildingName): static
    {
        $this->buildingName = $buildingName;

        return $this;
    }

    public function getFloorNumber(): ?int
    {
        return $this->floorNumber;
    }

    public function setFloorNumber(?int $floorNumber): static
    {
        $this->floorNumber = $floorNumber;

        return $this;
    }

    public function getWorkplaceId(): ?string
    {
        return $this->workplaceId;
    }

    public function setWorkplaceId(?string $workplaceId): static
    {
        $this->workplaceId = $workplaceId;

        return $this;
    }

    public function getInstallationDate(): ?\DateTimeInterface
    {
        return $this->installationDate;
    }

    public function setInstallationDate(?\DateTimeInterface $installationDate): static
    {
        $this->installationDate = $installationDate;

        return $this;
    }

    /**
     * @return Collection<int, SensorData>
     */
    public function getSensorData(): Collection
    {
        return $this->sensorData;
    }

    public function addSensorData(SensorData $sensorData): static
    {
        if (!$this->sensorData->contains($sensorData)) {
            $this->sensorData->add($sensorData);
            $sensorData->setSensor($this);
        }

        return $this;
    }

    public function removeSensorData(SensorData $sensorData): static
    {
        if ($this->sensorData->removeElement($sensorData)) {
            // set the owning side to null (unless already changed)
            if ($sensorData->getSensor() === $this) {
                $sensorData->setSensor(null);
            }
        }

        return $this;
    }

    public function getOrganization(): ?Organization
    {
        return $this->organization;
    }

    public function setOrganization(?Organization $organization): static
    {
        $this->organization = $organization;

        return $this;
    }
}

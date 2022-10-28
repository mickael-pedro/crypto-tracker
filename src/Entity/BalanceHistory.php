<?php

namespace App\Entity;

use App\Repository\BalanceHistoryRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BalanceHistoryRepository::class)]
class BalanceHistory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $BtcBalance = null;

    #[ORM\Column]
    private ?float $EthBalance = null;

    #[ORM\Column]
    private ?float $XrpBalance = null;

    #[ORM\Column]
    private ?float $TotalBalance = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Date = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBtcBalance(): ?float
    {
        return $this->BtcBalance;
    }

    public function setBtcBalance(float $BtcBalance): self
    {
        $this->BtcBalance = $BtcBalance;

        return $this;
    }

    public function getEthBalance(): ?float
    {
        return $this->EthBalance;
    }

    public function setEthBalance(float $EthBalance): self
    {
        $this->EthBalance = $EthBalance;

        return $this;
    }

    public function getXrpBalance(): ?float
    {
        return $this->XrpBalance;
    }

    public function setXrpBalance(float $XrpBalance): self
    {
        $this->XrpBalance = $XrpBalance;

        return $this;
    }

    public function getTotalBalance(): ?float
    {
        return $this->TotalBalance;
    }

    public function setTotalBalance(float $TotalBalance): self
    {
        $this->TotalBalance = $TotalBalance;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(\DateTimeInterface $Date): self
    {
        $this->Date = $Date;

        return $this;
    }
}

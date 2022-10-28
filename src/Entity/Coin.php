<?php

namespace App\Entity;

use App\Repository\CoinRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CoinRepository::class)]
class Coin
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $coinname = null;

    #[ORM\Column]
    private ?float $quantity = null;

    #[ORM\Column]
    private ?float $EurPrice = null;

    #[ORM\Column]
    private ?float $percentChange24h = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCoinname(): ?string
    {
        return $this->coinname;
    }

    public function setCoinname(string $coinname): self
    {
        $this->coinname = $coinname;

        return $this;
    }

    public function getQuantity(): ?float
    {
        return $this->quantity;
    }

    public function setQuantity(float $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getEurPrice(): ?float
    {
        return $this->EurPrice;
    }

    public function setEurPrice(float $EurPrice): self
    {
        $this->EurPrice = $EurPrice;

        return $this;
    }

    public function getPercentChange24h(): ?float
    {
        return $this->percentChange24h;
    }

    public function setPercentChange24h(float $percentChange24h): self
    {
        $this->percentChange24h = $percentChange24h;

        return $this;
    }
}

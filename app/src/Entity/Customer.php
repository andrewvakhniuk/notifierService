<?php

namespace App\Entity;

use App\Core\Enum\LocaleEnum;
use App\Repository\CustomerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CustomerRepository::class)]
class Customer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $phone;

    #[ORM\Column(length: 255)]
    private string $email;

    #[ORM\Column(length: 255, nullable: true)]
    private string $pushyToken;

    #[ORM\Column(length: 20, enumType: LocaleEnum::class)]
    private LocaleEnum $locale;

    public function __construct( string $email, string $phone, ?string $pushyToken = null, LocaleEnum $locale = LocaleEnum::DEFAULT)
    {
        $this->phone = $phone;
        $this->email = $email;
        $this->locale = $locale;
        $this->pushyToken = $pushyToken;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPushyToken(): ?string
    {
        return $this->pushyToken;
    }

    public function setPushyToken(?string $pushyToken): self
    {
        $this->pushyToken = $pushyToken;

        return $this;
    }

    public function getLocale(): LocaleEnum
    {
        return $this->locale;
    }

    public function setLocale(LocaleEnum $locale): self
    {
        $this->locale = $locale;

        return $this;
    }
}
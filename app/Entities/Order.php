<?php

namespace App\Entities;

use Doctrine\ORM\Mapping AS ORM;
use App\ValueObject\OrderStatusEnum;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="orders")
 */
class Order implements \JsonSerializable {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="string")
     */
    private $customer;

    /**
     * @ORM\Column(type="string")
     */
    private $address1;

    /**
     * @ORM\Column(type="string")
     */
    private $city;

    /**
     * @ORM\Column(type="string")
     */
    private $postcode;

    /**
     * @ORM\Column(type="string")
     */
    private $country;

    /**
     * @ORM\Column(type="integer")
     */
    private $amount;

    /**
     * @var OrderStatusEnum
     * ENUM('cancelled','in_production','pending','n/a')
     * @ORM\Column(name="status", type="string", length=20, nullable=false, options={"default": "n/a"})
     */
    private $status;

    /**
     * @ORM\Column(type="boolean")
     */
    private $deleted;

    /**
     * @ORM\Column(type="datetime")
     */
    private $last_modified;

    /**
     * @ORM\PostLoad
     */
    public function setStatusValue()
    {
        $this->status = new OrderStatusEnum($this->status);
    }

    public function __construct(array $data) {
        $this->id = $data["id"];
        $this->date = \DateTime::createFromFormat('Y-m-d H:i:s', $data["date"]);
        $this->customer = $data["customer"];
        $this->address1 = $data["address1"];
        $this->city = $data["city"];
        $this->postcode = $data["postcode"];
        $this->country = $data["country"];
        $this->amount = $data["amount"];
        $this->status = new OrderStatusEnum($data["status"]);
        $this->deleted = $data["deleted"];
        $this->last_modified = \DateTime::createFromFormat('Y-m-d H:i:s', $data["last_modified"]);
    }

    public function getLastModified(): \DateTime
    {
        return $this->last_modified;
    }

    public function setLastModified(string $last_modified): void
    {
        $this->last_modified = $last_modified;
    }

    public function getDeleted(): bool
    {
        return $this->deleted;
    }

    public function setDeleted(bool $deleted): void
    {
        $this->deleted = $deleted;
    }

    public function getStatus(): OrderStatusEnum
    {
        return $this->status;
    }

    public function setStatus(OrderStatusEnum $status): void
    {
        $this->status = $status;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    public function getPostcode(): string
    {
        return $this->postcode;
    }

    public function setPostcode(string $postcode): void
    {
        $this->postcode = $postcode;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    public function getAddress1(): string
    {
        return $this->address1;
    }

    public function setAddress1(string $address1): void
    {
        $this->address1 = $address1;
    }

    public function getCustomer(): string
    {
        return $this->customer;
    }

    public function setCustomer(string $customer): void
    {
        $this->customer = $customer;
    }

    public function getDate(): \DateTime
    {
        return $this->date;
    }

    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function __toString(): string
    {
        return json_encode([
            "id" => $this->getId(),
            "date" => $this->getDate()->format('Y-m-d H:i:s'),
            "customer" => $this->getCustomer(),
            "address1" => $this->getAddress1(),
            "city" => $this->getCity(),
            "postcode" => $this->getPostcode(),
            "country" => $this->getCountry(),
            "amount" => $this->getAmount(),
            "status" => $this->getStatus()->getValue(),
            "deleted" => $this->getDeleted() ? "Yes": "No",
            "lastModified" => $this->getLastModified()->format('Y-m-d H:i:s'),
        ]);
    }


    public function jsonSerialize(): ?\StdClass
    {
        return json_decode((string) $this);
    }
}

<?php
namespace App\ValueObject;


use JsonSerializable;

class OrderStatusEnum extends AbstractValueObject implements JsonSerializable {

  public const CANCELLED     = "cancelled";
  public const IN_PRODUCTION = "in_production";
  public const PENDING       = "pending";
  public const UNEXPECTED    = "n/a";

  public const AVAILABLE_STATUSES = [
      self::CANCELLED, self::IN_PRODUCTION, self::PENDING
  ];

    /**
     * @var string
     */
    protected $status;

    /**
     *
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->status = $value;

        if(!in_array($value, self::AVAILABLE_STATUSES)) {
            $this->status = self::UNEXPECTED;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getValue(): string
    {
        return $this->status;
    }

    public function jsonSerialize() {
        return $this->getValue();
    }

    public function __toString(): string
    {
        return $this->getValue();
    }
}

<?php

namespace App\UseCases\NotifyCustomer;

class NotifyCustomerCommand
{
    public function __construct(
        private readonly int $customerId,
        private readonly string $message
    )
    {
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getCustomerId(): int
    {
        return $this->customerId;
    }
}

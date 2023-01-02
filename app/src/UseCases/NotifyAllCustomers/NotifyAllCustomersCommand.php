<?php

namespace App\UseCases\NotifyAllCustomers;

class NotifyAllCustomersCommand
{
    public function __construct(private readonly string $message)
    {
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}

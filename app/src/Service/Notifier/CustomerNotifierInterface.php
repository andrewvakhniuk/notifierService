<?php

namespace App\Service\Notifier;

use App\Entity\Customer;

interface CustomerNotifierInterface
{
    public function send(Customer $customer, string $message): void;
}
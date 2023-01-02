<?php

namespace App\UseCases\NotifyAllCustomers;

use App\Repository\CustomerRepository;
use App\UseCases\NotifyCustomer\NotifyCustomerCommand;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler]
class NotifyAllCustomersHandler
{
    public function __construct(
        private readonly CustomerRepository $customerRepository,
        private readonly MessageBusInterface $bus
    )
    {
    }

    public function __invoke(NotifyAllCustomersCommand $command): void
    {
        $customers = $this->customerRepository->findAll();

        foreach ($customers as $customer) {
            $this->bus->dispatch(new NotifyCustomerCommand($customer->getId(), $command->getMessage()));
        }
    }
}
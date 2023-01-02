<?php

namespace App\UseCases\NotifyCustomer;

use App\Repository\CustomerRepository;
use App\Service\Notifier\CustomerNotifierInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class NotifyCustomerHandler
{
    public function __construct(
        private readonly CustomerRepository        $customerRepository,
        private readonly CustomerNotifierInterface $customerNotifier,
    )
    {
    }

    public function __invoke(NotifyCustomerCommand $command): void
    {
        $customer = $this->customerRepository->find($command->getCustomerId());
        if (!$customer) {
            return;
        }

        $this->customerNotifier->send($customer, $command->getMessage());
    }
}
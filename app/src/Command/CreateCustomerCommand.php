<?php

namespace App\Command;

use App\Core\Enum\LocaleEnum;
use App\Entity\Customer;
use App\Repository\CustomerRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Example:
 *
 * bin/console app:create-customer andrii@gmail.com +48881456544 pushy_token en
 */
class CreateCustomerCommand extends Command
{
    protected static $defaultName = 'app:create-customer';

    public function __construct(private readonly CustomerRepository $customerRepository)
    {
        parent::__construct(self::$defaultName);
    }

    //set customer variables as arguments
    protected function configure(): void
    {
        $this
            ->setDescription('Creates a new customer.')
            ->setHelp('This command allows you to create a customer...')
            ->addArgument('email', InputArgument::REQUIRED, 'The email of the customer.')
            ->addArgument('phone', InputArgument::REQUIRED, 'The phone of the customer.')
            ->addArgument('pushyToken', InputArgument::REQUIRED, 'The pushyToken of the customer.')
            ->addArgument('locale', InputArgument::OPTIONAL, 'The locale of the customer.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $email = $input->getArgument('email');
        $phone = $input->getArgument('phone');
        $pushyToken = $input->getArgument('pushyToken');
        $locale = LocaleEnum::from($input->getArgument('locale')) ?? LocaleEnum::DEFAULT;

        $customer = new Customer($email, $phone, $pushyToken, $locale);

        $this->customerRepository->save($customer, true);

        $output->writeln('Customer successfully created!');
        $output->writeln(sprintf('Customer details - email: %s, phone: %s, pushyToken: %s, locale: %s', $email, $phone, $pushyToken, $locale->value));

        return Command::SUCCESS;
    }
}
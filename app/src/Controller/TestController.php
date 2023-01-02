<?php

namespace App\Controller;

use App\Core\Enum\LocaleEnum;
use App\Service\Notifier\ChannelProviderInterface;
use App\Service\Notifier\Notification\MultiChannelNotification;
use App\Service\Notifier\Recipient\MultiChannelRecipient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    public function __construct(
        private readonly NotifierInterface $notifier,
        private readonly ChannelProviderInterface $channelProvider
    )
    {
    }

    /**
     * Example:
     *
     * http://localhost/test/greetings/mail@gmail.com/phone_number/pushy_token/en
     */
    #[Route('/test/{message}/{email}/{phone}/{pushyToken}/{locale}', name: 'test', methods: ['GET'])]
    public function __invoke(string $message, string $email, string $phone, string $pushyToken, string $locale = 'ua'): Response
    {
        $notification = new MultiChannelNotification($message, [$this->channelProvider->provideInitial()], LocaleEnum::from($locale));
        $recipient = new MultiChannelRecipient($email, $phone, $pushyToken);

        $this->notifier->send($notification, $recipient);

        return new Response('ok');
    }
}
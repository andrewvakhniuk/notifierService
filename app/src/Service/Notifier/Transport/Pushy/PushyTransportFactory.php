<?php

namespace App\Service\Notifier\Transport\Pushy;


use App\Service\PushyClient\PushyClient;
use Symfony\Component\Notifier\Exception\UnsupportedSchemeException;
use Symfony\Component\Notifier\Transport\AbstractTransportFactory;
use Symfony\Component\Notifier\Transport\Dsn;
use Symfony\Component\Notifier\Transport\TransportInterface;

class PushyTransportFactory extends AbstractTransportFactory
{
    protected function getSupportedSchemes(): array
    {
        return [PushyTransport::TRANSPORT];
    }

    public function create(Dsn $dsn): TransportInterface
    {
        $scheme = $dsn->getScheme();

        if (PushyTransport::TRANSPORT !== $scheme) {
            throw new UnsupportedSchemeException($dsn, PushyTransport::TRANSPORT, $this->getSupportedSchemes());
        }

        $apiKey = $this->getUser($dsn);

        return new PushyTransport(new PushyClient($apiKey), $this->client, $this->dispatcher);
    }
}
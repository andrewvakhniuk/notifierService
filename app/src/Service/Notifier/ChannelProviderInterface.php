<?php

namespace App\Service\Notifier;

interface ChannelProviderInterface
{
    public function provideNextInFailoverOrder(string $failedChannel): ?string;
    public function provideInitial(): string;
}
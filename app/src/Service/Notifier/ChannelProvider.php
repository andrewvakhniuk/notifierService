<?php

namespace App\Service\Notifier;

use App\Core\Enum\NotificationChannelEnum;
use Exception;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class ChannelProvider implements ChannelProviderInterface
{
    /**
     * @throws Exception
     */
    public function __construct(#[Autowire('%channel_failover_order%')] private array $channelFailoverOrder)
    {
        $this->validateChannels();
    }

    public function provideInitial(): string
    {
        return reset($this->channelFailoverOrder);
    }

    public function provideNextInFailoverOrder(string $failedChannel): ?string
    {
        $failedChannelIndex = array_search($failedChannel, $this->channelFailoverOrder, strict: true);

        /**
         * Failed channel not found in the failover order.
         */
        if($failedChannelIndex === false) {
            throw new \RuntimeException(sprintf('Failed channel "%s" not found in the failover order.', $failedChannel));
        }

        return $this->channelFailoverOrder[$failedChannelIndex + 1] ?? null;
    }

    /**
     * @throws Exception
     */
    private function validateChannels()
    {
        if(count($this->channelFailoverOrder) === 0) {
            throw new Exception('Channel failover order is empty.');
        }

        $validChannels = NotificationChannelEnum::getChannels();

        foreach ($this->channelFailoverOrder as $channel) {
            if (!in_array($channel, $validChannels, strict: true)) {
                throw new Exception(sprintf('Invalid channel provided in configs: %s', $channel));
            }
        }
    }
}

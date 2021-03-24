<?php

declare(strict_types=1);

namespace Titi60\SyliusFacebookPlugin\Repository;

use Titi60\SyliusFacebookPlugin\Model\PixelInterface;
use Sylius\Component\Channel\Model\ChannelInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

interface PixelRepositoryInterface extends RepositoryInterface
{
    /**
     * Returns the pixels that are enabled and enabled on the given channel
     *
     * @return PixelInterface[]
     */
    public function findEnabledByChannel(ChannelInterface $channel): array;
}

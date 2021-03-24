<?php

declare(strict_types=1);

namespace Titi60\SyliusFacebookPlugin\Model;

use Sylius\Component\Channel\Model\ChannelsAwareInterface;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\ToggleableInterface;

interface PixelInterface extends ResourceInterface, ToggleableInterface, ChannelsAwareInterface
{
    public function getId(): ?int;

    public function getPixelId(): ?string;

    public function setPixelId(string $pixelId): void;
}

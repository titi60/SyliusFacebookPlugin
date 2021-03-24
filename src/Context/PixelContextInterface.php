<?php

declare(strict_types=1);

namespace Titi60\SyliusFacebookPlugin\Context;

use Titi60\SyliusFacebookPlugin\Model\PixelInterface;

interface PixelContextInterface
{
    /**
     * Returns the pixels enabled for the active channel
     *
     * @return PixelInterface[]
     */
    public function getPixels(): array;
}

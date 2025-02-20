<?php

declare(strict_types=1);

namespace Titi60\SyliusFacebookPlugin\Event;

use Titi60\SyliusFacebookPlugin\Builder\BuilderInterface;
use Symfony\Contracts\EventDispatcher\Event;

final class BuilderEvent extends Event
{
    private BuilderInterface $builder;

    /** @var mixed|null */
    private $subject;

    /**
     * @param mixed|null $subject
     */
    public function __construct(BuilderInterface $builder, $subject = null)
    {
        $this->builder = $builder;
        $this->subject = $subject;
    }

    public function getBuilder(): BuilderInterface
    {
        return $this->builder;
    }

    /**
     * @return mixed|null
     */
    public function getSubject()
    {
        return $this->subject;
    }
}

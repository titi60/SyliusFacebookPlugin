<?php

declare(strict_types=1);

namespace Titi60\SyliusFacebookPlugin\EventListener;

use Titi60\SyliusFacebookPlugin\Builder\AddToCartBuilder;
use Titi60\SyliusFacebookPlugin\Builder\ContentBuilder;
use Titi60\SyliusFacebookPlugin\Context\PixelContextInterface;
use Titi60\SyliusFacebookPlugin\Event\BuilderEvent;
use Titi60\SyliusFacebookPlugin\Tag\FbqTag;
use Titi60\SyliusFacebookPlugin\Tag\FbqTagInterface;
use Titi60\SyliusFacebookPlugin\Tag\Tags;
use Setono\TagBag\Tag\TagInterface;
use Setono\TagBag\TagBagInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Order\Context\CartContextInterface;
use Symfony\Bundle\SecurityBundle\Security\FirewallMap;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RequestStack;

final class AddToCartSubscriber extends TagSubscriber
{
    private CartContextInterface $cartContext;

    public function __construct(
        TagBagInterface $tagBag,
        PixelContextInterface $pixelContext,
        EventDispatcherInterface $eventDispatcher,
        CartContextInterface $cartContext,
        RequestStack $requestStack,
        FirewallMap $firewallMap
    ) {
        parent::__construct($tagBag, $pixelContext, $eventDispatcher, $requestStack, $firewallMap);

        $this->cartContext = $cartContext;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'sylius.order_item.post_add' => [
                'track',
            ],
        ];
    }

    public function track(): void
    {
        if (!$this->isShopContext() || !$this->hasPixels()) {
            return;
        }

        $order = $this->cartContext->getCart();

        if (!$order instanceof OrderInterface) {
            return;
        }

        $builder = AddToCartBuilder::create()
            ->setCurrency($order->getCurrencyCode())
            ->setValue($this->moneyFormatter->format($order->getTotal()))
            ->setContentType(AddToCartBuilder::CONTENT_TYPE_PRODUCT)
        ;

        foreach ($order->getItems() as $item) {
            $variant = $item->getVariant();
            if (null === $variant) {
                continue;
            }

            $builder->addContentId($variant->getCode());

            $contentBuilder = ContentBuilder::create()
                ->setId($variant->getCode())
                ->setQuantity($item->getQuantity())
                ->setItemPrice($this->moneyFormatter->format($item->getDiscountedUnitPrice()))
            ;

            $this->eventDispatcher->dispatch(new BuilderEvent($contentBuilder, $item));

            $builder->addContent($contentBuilder);
        }

        $this->eventDispatcher->dispatch(new BuilderEvent($builder, $order));

        $this->tagBag->addTag(
            (new FbqTag(FbqTagInterface::EVENT_ADD_TO_CART, $builder))
                ->setSection(TagInterface::SECTION_BODY_END)
                ->setName(Tags::TAG_ADD_TO_CART)
        );
    }
}

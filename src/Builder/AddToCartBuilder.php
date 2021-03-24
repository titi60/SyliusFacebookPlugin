<?php

declare(strict_types=1);

namespace Titi60\SyliusFacebookPlugin\Builder;

final class AddToCartBuilder extends Builder
{
    use ContentIdsAwareBuilderTrait,
        ContentsAwareBuilderTrait,
        ContentTypeAwareBuilderTrait,
        ValueAwareBuilderTrait
    ;
}

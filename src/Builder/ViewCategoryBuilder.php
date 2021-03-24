<?php

declare(strict_types=1);

namespace Titi60\SyliusFacebookPlugin\Builder;

final class ViewCategoryBuilder extends Builder
{
    use ContentIdsAwareBuilderTrait,
        ContentNameAwareBuilderTrait,
        ContentsAwareBuilderTrait,
        ContentTypeAwareBuilderTrait,
        ContentCategoryAwareBuilderTrait
    ;
}

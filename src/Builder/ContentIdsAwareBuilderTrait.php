<?php

declare(strict_types=1);

namespace Titi60\SyliusFacebookPlugin\Builder;

use Webmozart\Assert\Assert;

/**
 * @mixin Builder
 */
trait ContentIdsAwareBuilderTrait
{
    /**
     * @param mixed $contentId
     */
    public function addContentId($contentId): self
    {
        \assert($this instanceof Builder);

        if (!isset($this->data['content_ids'])) {
            $this->data['content_ids'] = [];
        }

        Assert::scalar($contentId);

        $this->data['content_ids'][] = $contentId;

        return $this;
    }
}

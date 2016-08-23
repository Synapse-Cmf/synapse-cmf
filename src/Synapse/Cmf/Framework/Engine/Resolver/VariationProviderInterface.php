<?php

namespace Synapse\Cmf\Framework\Engine\Resolver;

use Synapse\Cmf\Framework\Theme\Variation\Entity\VariationContext;

/**
 * Behavior definition for classes which adds some vars
 * to variation resolution engine, throught expression language.
 *
 * @see Symfony\Component\ExpressionLanguage\ExpressionLanguage
 */
interface VariationProviderInterface
{
    /**
     * Adds vars into given context.
     *
     * @example
     *     $context->foo = bar;
     *     $context->denormalize($request->query->all());
     *
     * @param VariationContext $context
     *
     * @return VariationContext|null
     */
    public function hydrateContext(VariationContext $context);
}

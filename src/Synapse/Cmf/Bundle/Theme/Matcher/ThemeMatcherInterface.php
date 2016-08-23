<?php

namespace Synapse\Cmf\Bundle\Theme\Matcher;

/**
 * Interface to define theme matching from a context.
 */
interface ThemeMatcherInterface
{
    /**
     * Analyze given context for matching a theme name, throws an InvalidThemeException otherwise.
     *
     * @param ThemeMatchingContext $context
     *
     * @return string
     *
     * @throws Synapse\Cmf\Framework\Engine\Exception\InvalidThemeException
     */
    public function match(ThemeMatchingContext $context);
}

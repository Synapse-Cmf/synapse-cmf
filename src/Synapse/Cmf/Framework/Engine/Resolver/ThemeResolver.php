<?php

namespace Synapse\Cmf\Framework\Engine\Resolver;

use Synapse\Cmf\Framework\Engine\Exception\InvalidThemeException;
use Synapse\Cmf\Framework\Theme\Theme\Loader\LoaderInterface as ThemeLoader;

class ThemeResolver
{
    /**
     * @var ThemeLoader
     */
    protected $themeLoader;

    /**
     * Construct.
     *
     * @param ThemeLoader $themeLoader
     */
    public function __construct(ThemeLoader $themeLoader)
    {
        $this->themeLoader = $themeLoader;
    }

    /**
     * Select Theme to use from given parameters and return it.
     *
     * @param string $themeName optional theme name to use
     *
     * @return Theme
     */
    public function resolve($themeName)
    {
        switch (true) {

            // given theme name
            case $themeName:
                if (!$theme = $this->themeLoader->retrieveByName($themeName)) {
                    throw new InvalidThemeException(sprintf(
                        'Any registered theme under name "%s". Please check your configuration.',
                        $themeName
                    ));
                }
            break;

            // default theme
            case $theme = $this->themeLoader->retrieveOne(array('default' => true)):
            break;

            // first theme defined
            default:
                $theme = $this->themeLoader->retrieveOne();
        }
        if (empty($theme)) {
            throw new InvalidThemeException('No valid theme found. Please check your configuration.');
        }

        return $theme;
    }
}

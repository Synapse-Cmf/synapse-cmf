<?php

namespace Synapse\Cmf\Framework\Engine\Resolver;

use Synapse\Cmf\Framework\Engine\Exception\InvalidThemeException;
use Synapse\Cmf\Framework\Theme\Theme\Loader\LoaderInterface as ThemeLoader;
use Synapse\Cmf\Framework\Theme\Theme\Model\ThemeInterface;

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
     *
     * @throws InvalidThemeException If no theme found for given theme name
     */
    public function resolve($themeName = null)
    {
        switch (true) {

            // given theme name
            case $themeName:
                if (!$theme = $this->themeLoader->retrieveByName($themeName)) {
                    throw new InvalidThemeException(sprintf(
                        'No themes registered under for "%s" theme name. Did you mean one of these themes : %s ?',
                        $themeName,
                        $this->themeLoader->retrieveAll()->display('name')
                    ));
                }
            break;

            // // default theme - not yet implemented
            // case $theme = $this->themeLoader->retrieveOne(array(
            //     'default' => true
            // )):
            // break;

            // first theme defined if there is only one activated
            case ($themes = $this->themeLoader->retrieveAll())
                && $themes->count() == 1:
                $theme = $themes->first();
            break;

            default:
                throw new InvalidThemeException(
                    'Unavailable to determine which theme to use, if you are using more than one you have to call one explicitely. See online documentation at https://synapse-cmf.github.io/documentation/fr/3_book/1_decorator/2_themes.html for more informations.'
                );
        }

        return $theme;
    }
}

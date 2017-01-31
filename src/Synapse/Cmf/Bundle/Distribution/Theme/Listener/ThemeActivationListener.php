<?php

namespace Synapse\Cmf\Bundle\Distribution\Theme\Listener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\RouterInterface;
use Synapse\Cmf\Bundle\Theme\Matcher\ThemeMatcher;
use Synapse\Cmf\Bundle\Theme\Matcher\ThemeMatchingContext;
use Synapse\Cmf\Framework\Engine\Engine;

/**
 * Listener class, bridge between Request and ThemeMatcher.
 */
class ThemeActivationListener extends ThemeMatcher implements EventSubscriberInterface
{
    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * Construct.
     *
     * @param RouterInterface    $router
     * @param Engine             $synapseEngine
     * @param ExpressionLanguage $expressionParser
     */
    public function __construct(
        RouterInterface $router,
        Engine $synapseEngine,
        ExpressionLanguage $expressionParser
    ) {
        parent::__construct($synapseEngine, $expressionParser);

        $this->router = $router;
    }

    /**
     * @see EventSubscriberInterface::getSubscribedEvents()
     */
    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::REQUEST => 'onKernelRequest',
        );
    }

    /**
     * "kernel.request" event handler.
     *
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        $route = $this->router->getRouteCollection()->get(
            $request->attributes->get('_route')
        );
        if (!$route || !$themeOptions = $route->getOption('synapse_theme')) {
            return;
        }

        $request->attributes->set('synapse_theme', $this->match(
            $themeOptions,
            new ThemeMatchingContext(array(
                'host' => $request->server->get('HTTP_HOST'),
            ))
        ));
    }
}

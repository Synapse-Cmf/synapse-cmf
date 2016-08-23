<?php

namespace Synapse\Cmf\Bundle\Distribution\Component\Listener;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Synapse\Cmf\Framework\Engine\Context\Component\RenderingContextNormalizer;
use Synapse\Cmf\Framework\Engine\Context\RenderingContextStack;
use Synapse\Cmf\Framework\Engine\Decorator\Component\HtmlDecorator;

/**
 * Listener class for requests on component controllers.
 *
 * Handle context refreshing on ESI cases and all data setUp if necessary
 */
class ComponentRequestListener
{
    /**
     * @var RenderingContextStack
     */
    protected $contextStack;

    /**
     * @var HtmlDecorator
     */
    protected $componentDecorator;

    /**
     * @var RenderingContextNormalizer
     */
    protected $contextNormalizer;

    /**
     * Construct.
     *
     * @param RenderingContextStack      $contextStack
     * @param HtmlDecorator              $componentDecorator
     * @param RenderingContextNormalizer $contextNormalizer
     */
    public function __construct(
        RenderingContextStack $contextStack,
        HtmlDecorator $componentDecorator,
        RenderingContextNormalizer $contextNormalizer
    ) {
        $this->contextStack = $contextStack;
        $this->componentDecorator = $componentDecorator;
        $this->contextNormalizer = $contextNormalizer;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        if ($event->isMasterRequest()) {
            return;
        }
        $request = $event->getRequest();
        if (!$request->query->has('_s_context')) {
            return;
        }

        // test
        $this->contextStack->pop();

        // Component context isn't initialized (ESI cases)
        if ($this->contextStack->getLevel() != RenderingContextStack::COMPONENT) {
            try {
                $this->componentDecorator->prepare(
                    ...$this->contextNormalizer->denormalize($request->query->all())
                );
            } catch (\InvalidArgumentException $e) {
                throw new NotFoundHttpException($e->getMessage(), $e);
            }
        }

        $context = $this->contextStack->getCurrent();
        $request->attributes->set('component', $context->getComponent());
        $request->attributes->set('config', $context->getConfig());
        $request->attributes->set('content', $context->getContent());
    }
}

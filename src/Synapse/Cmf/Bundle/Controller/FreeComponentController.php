<?php

namespace Synapse\Cmf\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Synapse\Cmf\Framework\Theme\Component\Model\ComponentInterface;
use Synapse\Cmf\Framework\Theme\Content\Model\ContentInterface;

/**
 * Free component type controller.
 */
class FreeComponentController extends Controller
{
    /**
     * Component rendering action.
     *
     * @param ComponentInterface $component
     * @param ContentInterface   $content
     *
     * @return Response
     */
    public function renderAction(ComponentInterface $component, ContentInterface $content)
    {
        if (empty($component->getData('html'))) {
            // @todo log
            return new Response('');
        }

        return $this->get('synapse')
            ->createDecorator($component)
            ->decorate(array('content' => $content))
        ;
    }
}

<?php

namespace Synapse\Cmf\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Synapse\Cmf\Framework\Theme\Component\Model\ComponentInterface;
use Synapse\Cmf\Framework\Theme\Content\Model\ContentInterface;

/**
 * Menu component type controller.
 */
class MenuComponentController extends Controller
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
        $menu = array();
        foreach ($component->getData('tree', array()) as $linkData) {
            // name / url required
            if (empty($linkData['name']) || empty($linkData['url'])) {
                continue;
            }
            $menu[$linkData['name']] = array(
                'url' => $linkData['url'],
                'children' => array(),
            );
        }

        return $this->get('synapse')
            ->createDecorator($component)
            ->decorate(array(
                'content' => $content,
                'menu' => $menu,
            ))
        ;
    }
}

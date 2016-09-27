<?php

namespace Synapse\Page\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Synapse\Cmf\Framework\Theme\Component\Model\ComponentInterface;
use Synapse\Cmf\Framework\Theme\Content\Model\ContentInterface;

class PageMenuContentController extends Controller
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
        $pageLoader = $this->get('synapse.page.loader');

        foreach ($component->getData('data', array()) as $menuData) {
            // name / url required
            if (empty($menuData['label']) || empty($menuData['page'])) {
                continue;
            }
            // page exists or is online ?
            if (!$page = $pageLoader->retrieve($menuData['page'])) {
                continue;
            }
            if (!$page->isOnline()) {
                continue;
            }
            $menu[$menuData['position']] = array(
                'label' => $menuData['label'],
                'url' => $this->get('router')->generate('synapse_content_type_page', ['path' => $page->getPath()]),
            );
        }

        return $this->get('synapse')
            ->createDecorator($component)
            ->decorate(array(
                'content' => $content,
                'page_menu' => $menu,
            ))
            ;
    }
}

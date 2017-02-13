<?php

namespace Synapse\Page\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Synapse\Page\Bundle\Entity\Page;

/**
 * Controller class for Page Synapse content type.
 */
class PageContentController extends Controller
{
    /**
     * Call Synapse to render given page.
     *
     * @param Page    $page
     * @param Request $request
     *
     * @return Response
     */
    private function renderPage(Page $page, Request $request)
    {
        return $this->get('synapse')
            ->createDecorator($page)
            ->decorate(array(
                'page' => $page,
                'request' => $request,
            ))
        ;
    }

    /**
     * Page preview action.
     *
     * @param int     $id
     * @param Request $request
     *
     * @return Response
     */
    public function previewAction($id, Request $request)
    {
        if (!$page = $this->get('synapse.page.loader')->retrieve($id)) {
            throw new NotFoundHttpException(sprintf('"Page#%s" not found.',
                $id
            ));
        }

        return $this->renderPage($page, $request);
    }

    /**
     * Page rendering action.
     *
     * @param string  $path    requested Page path
     * @param Request $request
     *
     * @return Response
     */
    public function renderAction($path, Request $request)
    {
        if (!$page = $this->get('synapse.page.loader')->retrieveByPath($path, true)) {
            throw new NotFoundHttpException(sprintf('No online page found at path "%s".',
                $path
            ));
        }

        return $this->renderPage($page, $request);
    }
}

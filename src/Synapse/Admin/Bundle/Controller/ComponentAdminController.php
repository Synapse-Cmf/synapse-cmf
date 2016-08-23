<?php

namespace Synapse\Admin\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Controller for components management use cases action.
 */
class ComponentAdminController extends Controller
{
    /**
     * Component deletion action.
     *
     * @param int     $id
     * @param Request $request
     *
     * @return Response
     */
    public function deleteAction($id, Request $request)
    {
        if (!$component = $this->container->get('synapse.component.loader')->retrieve($id)) {
            throw new NotFoundHttpException(sprintf('No component found under id "%s"', $id));
        }

        $this->container->get('synapse.component.domain')->delete($component);

        return new RedirectResponse(
            $request->server->get('HTTP_REFERER')
        );
    }
}

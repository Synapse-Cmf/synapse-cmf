<?php

namespace Synapse\Admin\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Controller for zones management use cases action.
 */
class ZoneAdminController extends Controller
{
    /**
     * Zone component add action.
     *
     * @param int     $id
     * @param Request $request
     *
     * @return Response
     */
    public function addComponentAction($id, $componentTypeId, Request $request)
    {
        if (!$zone = $this->container->get('synapse.zone.loader')->retrieve($id)) {
            throw new NotFoundHttpException(sprintf('No zone found under id "%s"', $id));
        }
        if (!$componentType = $this->container->get('synapse.component_type.loader')->retrieve($componentTypeId)) {
            throw new NotFoundHttpException(sprintf('No component type found under id "%s"', $componentTypeId));
        }

        $this->container->get('synapse.zone.domain')->addComponent($zone, $componentType);

        return new RedirectResponse(
            $request->server->get('HTTP_REFERER')
        );
    }
}

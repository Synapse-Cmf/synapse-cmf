<?php

namespace Synapse\Admin\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Controller for zones use cases action.
 */
class ZoneAdminController extends Controller
{
    /**
     * Component deletion action.
     *
     * @param int     $zoneId
     * @param int     $componentId
     * @param Request $request
     *
     * @return Response
     */
    public function deleteAction($zoneId, $componentId, Request $request)
    {
        if (!$zone = $this->container->get('synapse.zone.loader')->retrieve($zoneId)) {
            throw new NotFoundHttpException(sprintf('No zone found under id "%s"', $zoneId));
        }
        if (!$component = $this->container->get('synapse.component.loader')->retrieve($componentId)) {
            throw new NotFoundHttpException(sprintf('No component found under id "%s"', $componentId));
        }

        $this->container->get('synapse.zone.domain')->removeComponent(
            $zone,
            $component
        );

        return new RedirectResponse(
            $request->server->get('HTTP_REFERER')
        );
    }
}

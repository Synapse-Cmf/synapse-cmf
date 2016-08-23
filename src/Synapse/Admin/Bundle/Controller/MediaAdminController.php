<?php

namespace Synapse\Admin\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Synapse\Cmf\Framework\Media\Media\Domain\Exception\UnsupportedFileException;

/**
 * Controller for media management use cases action.
 */
class MediaAdminController extends Controller
{
    /**
     * Media list action.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function listAction(Request $request)
    {
        return $this->render('SynapseAdminBundle:Media:list.html.twig', array(
            'assets_path' => $this->container->getParameter('synapse.media_store.web_path'),
            'medias' => $this->container->get('synapse.image.loader')->retrieveAll(),
        ));
    }

    /**
     * Media upload action throught XmlHttpRequest.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function xhrFileUploadAction(Request $request)
    {
        if (!$request->files->has('file')) {
            return new JsonResponse(
                array(
                    'error' => 400,
                    'error_message' => 'File to upload have to be under "file" key.',
                ),
                400
            );
        }
        try {
            return new JsonResponse(
                array('file' => $this->container->get('synapse.media.domain')
                    ->upload($request->files->get('file'))
                    ->normalize(),
                ),
                201
            );
        } catch (UnsupportedFileException $e) {
            return new JsonResponse(
                array(
                    'error' => 400,
                    'error_message' => 'File isnt supported by Synapse.',
                    'error_full_message' => $e->getMessage(),
                ),
                400
            );
        }
    }
}

<?php

namespace Synapse\Admin\Bundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Synapse\Cmf\Bundle\Form\Type\Media\FormatType;
use Synapse\Cmf\Bundle\Form\Type\Media\ImageType;
use Synapse\Cmf\Framework\Media\Image\Entity\Image;

/**
 * Controller for image management use cases action.
 */
class ImageAdminController extends Controller implements ParamConverterInterface
{
    /**
     * @see ParamConverterInterface::supports()
     */
    public function supports(ParamConverter $configuration)
    {
        return $configuration->getClass() == Image::class;
    }

    /**
     * @see ParamConverterInterface::apply()
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        if (!$image = $this->container->get('synapse.image.loader')
            ->retrieve($imageId = $request->attributes->get('id'))
        ) {
            throw new NotFoundHttpException(sprintf('Image#%d not found.', $imageId));
        }

        $request->attributes->set(
            $configuration->getName(),
            $image
        );

        return true;
    }

    /**
     * Image edition action.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function editAction(Image $image, Request $request)
    {
        $form = $this->container->get('form.factory')->createNamed(
            'image',
            ImageType::class,
            $image,
            array(
                'action' => $this->container->get('router')->generate(
                    'synapse_admin_image_edition',
                    array('id' => $image->getId())
                ),
                'method' => 'POST',
                'csrf_protection' => false,
            )
        );
        if ($request->request->has('image')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                return $this->redirect(
                    $this->container->get('router')->generate(
                        'synapse_admin_image_edition',
                        array('id' => $image->getId())
                    )
                );
            }
        }

        return $this->render('SynapseAdminBundle:Image:edit.html.twig', array(
            'image' => $image,
            'theme' => $request->attributes->get(
                'synapse_theme',
                $this->container->get('synapse')
                    ->enableDefaultTheme()
                    ->getCurrentTheme()
            ),
            'form' => $form->createView(),
        ));
    }

    /**
     * Image formating action through XmlHttpRequest.
     *
     * @param Image   $image
     * @param string  $formatName
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function xhrFormatAction(Image $image, $formatName, Request $request)
    {
        // retrieve format value object
        if (!$format = $this->container->get('synapse.image_format.loader')
            ->retrieveOne(array('name' => $formatName))
        ) {
            return new JsonResponse(
                array(
                    'error' => 400,
                    'error_message' => sprintf('No format found with name "%s".', $formatName),
                ),
                400
            );
        }

        // form handle
        $form = $this->container->get('form.factory')->createNamed(
            '',
            FormatType::class,
            $image,
            array(
                'format' => $format,
                'method' => 'POST',
                'csrf_protection' => false,
            )
        );
        $form->handleRequest($request);
        if (!$form->isValid()) {
            return new JsonResponse(
                array(
                    'error' => 400,
                    'error_message' => 'Invalid format data.',
                ),
                400
            );
        }

        // formatted image data
        return new JsonResponse(
            $form->getData()
                ->getFormattedImage($formatName)
                ->normalize(),
            201
        );
    }
}

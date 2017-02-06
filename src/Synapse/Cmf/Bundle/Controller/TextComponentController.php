<?php

namespace Synapse\Cmf\Bundle\Controller;

use Majora\Framework\Model\EntityCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Synapse\Cmf\Framework\Media\Image\Model\ImageInterface;
use Synapse\Cmf\Framework\Theme\Component\Model\ComponentInterface;
use Synapse\Cmf\Framework\Theme\Content\Model\ContentInterface;

/**
 * Text component type controller.
 */
class TextComponentController extends Controller
{
    /**
     * Component rendering action.
     *
     * @param ComponentInterface $component
     * @param array              $config
     * @param ContentInterface   $content
     *
     * @return Response
     */
    public function renderAction(ComponentInterface $component, array $config, ContentInterface $content)
    {
        //
        // Data validation
        //
        if (!$component->getData('text')) {
            $this->container->get('logger')->warning(
                'Incomplete text component, "text" field has to be fullfilled.',
                array(
                    'component_id' => $component->getId(),
                    'content_class' => get_class($content),
                    'content_id' => $content->getId()
                )
            );

            return new Response('');
        }

        $templateParameters = array(
            'config' => $config,
            'content' => $content,
        );

        //
        // Medias
        //
        $templateParameters['images'] = (new EntityCollection((array) $component->getData('images')))
            ->map(function ($imageId) {
                return $this->get('synapse.image.loader')->retrieve($imageId);
            })
            ->filter(function ($image) {
                return (bool) $image;
            })
            ->map(function (ImageInterface $image) use ($config) {
                return $image->setDefaultFormat(
                    empty($config['images']['format']) ? null : $config['images']['format']
                );
            })
        ;
        if (!$config['images']['multiple']) {
            $templateParameters['image'] = $templateParameters['images']->first();
        }

        //
        // Resolution
        //
        return $this->get('synapse')
            ->createDecorator($component)
            ->decorate($templateParameters)
        ;
    }
}

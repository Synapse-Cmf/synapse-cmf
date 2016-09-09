<?php

namespace Synapse\Cmf\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
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
        if (!$component->getData('text') && !$component->getData('title')) {
            // @todo log
            return new Response('');
        }

        // guess medias
        $mediaCollection = array();

        if ($component->getData('video_link')) {            // video
            $mediaCollection[sprintf('%s-video', $component->getId())] = array(
                'type' => 'video',
                'src' => $component->getData('video_link'),
            );
        }

        if ($component->getData('images', array())) {       // images
            foreach ((array) $component->getData('images', array()) as $index => $imageId) {
                if (!$image = $this->get('synapse.image.loader')->retrieve($imageId)) {
                    continue;
                }
                $mediaCollection[sprintf('%s-%s-%s', $component->getId(), $imageId, $index)] = array(
                    'type' => 'image',
                    'label' => $image->getTitle(),
                    'object' => $image,
                );
            }
        }

        // links
        $linkCollection = array();
        if ($component->getData('link')) {  // read more link
            $linkCollection[$component->getData('link_label', 'Read more')] = $component->getData('link');
        }

        return $this->get('synapse')
            ->createDecorator($component)
            ->decorate(array(
                'config' => $config,
                'content' => $content,
                'media_collection' => $mediaCollection,
                'link_collection' => $linkCollection,
            ))
        ;
    }
}

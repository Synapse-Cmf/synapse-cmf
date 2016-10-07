<?php

namespace Synapse\Cmf\Bundle\Form\Type\Media;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Synapse\Cmf\Bundle\Entity\Orm\Image;
use Synapse\Cmf\Framework\Media\Image\Entity\ImageCollection;
use Synapse\Cmf\Framework\Media\Image\Loader\LoaderInterface as ImageLoader;

/**
 * Custom choice type for Synapse image selector.
 */
class ImageChoiceType extends AbstractType
{
    /**
     * @var ImageCollection
     */
    protected $imageCollection;

    /**
     * Construct.
     *
     * @param ImageLoader $imageLoader
     */
    public function __construct(ImageLoader $imageLoader)
    {
        $this->imageCollection = $imageLoader->retrieveAll()->indexBy('id');
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return ChoiceType::class;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefined('image_formats');

        $resolver->setDefaults(array(
            'choices' => $this->imageCollection
                ->map(function (Image $image) {
                    return $image->getId();
                })
                ->toArray(),
            'choice_label' => function ($value, $key, $index) {
                return $this->imageCollection->get($value)->getName();
            },
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['attr'] = array(
            'class' => 'image_choice_list',
            'style' => 'width: 100%;',
        );
    }
}

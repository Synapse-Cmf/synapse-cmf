<?php

namespace Synapse\Cmf\Bundle\Form\Type\Framework;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Synapse\Cmf\Bundle\Form\Type\Framework\Component\CreationType as ComponentCreationType;
use Synapse\Cmf\Bundle\Form\Type\Framework\Component\EditionType as ComponentEditionType;
use Synapse\Cmf\Framework\Engine\Resolver\VariationResolver;
use Synapse\Cmf\Framework\Theme\ComponentType\Model\ComponentTypeInterface;
use Synapse\Cmf\Framework\Theme\ContentType\Model\ContentTypeInterface;
use Synapse\Cmf\Framework\Theme\TemplateType\Model\TemplateTypeInterface;
use Synapse\Cmf\Framework\Theme\Theme\Model\ThemeInterface;
use Synapse\Cmf\Framework\Theme\Variation\Entity\VariationContext;
use Synapse\Cmf\Framework\Theme\Zone\Action\Dal\UpdateAction;
use Synapse\Cmf\Framework\Theme\Zone\Domain\Action\ActionDispatcherDomain as ZoneDomain;
use Synapse\Cmf\Framework\Theme\Zone\Model\ZoneInterface;

/**
 * Zone edition form type.
 */
class ZoneType extends AbstractType implements DataTransformerInterface
{
    /**
     * @var ZoneDomain
     */
    protected $zoneDomain;

    /**
     * @var VariationResolver
     */
    protected $variationResolver;

    /**
     * Construct.
     *
     * @param ZoneDomain        $zoneDomain
     * @param VariationResolver $variationResolver
     */
    public function __construct(ZoneDomain $zoneDomain, VariationResolver $variationResolver)
    {
        $this->zoneDomain = $zoneDomain;
        $this->variationResolver = $variationResolver;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('theme');
        $resolver->setAllowedTypes('theme', ThemeInterface::class);

        $resolver->setRequired('content_type');
        $resolver->setAllowedTypes('content_type', ContentTypeInterface::class);

        $resolver->setRequired('template_type');
        $resolver->setAllowedTypes('template_type', TemplateTypeInterface::class);

        $resolver->setDefaults(array(
            'cascade_validation' => false,
            'data_class' => UpdateAction::class,
        ));
    }

    /**
     * @see DataTransformerInterface::transform()
     */
    public function transform($data)
    {
        if ($data instanceof UpdateAction) {
            return $data;
        }
        if ($data instanceof ZoneInterface) {
            return $this->zoneDomain->getAction('update', $data);
        }

        throw new TransformationFailedException(sprintf(
            'Zone edition type only supports zone or zone update action. "%s" given.',
            gettype($data)
        ));
    }

    /**
     * Page form prototype definition.
     *
     * @see FormInterface::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addModelTransformer($this)
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($builder, $options) {
                $form = $event->getForm();
                $zone = $event->getData();

                // Create a component form for each into given zone
                $form->add('components', CollectionType::class, array(
                    'auto_initialize' => false,
                    'allow_add' => false,
                    'allow_delete' => false,
                    'entry_type' => ComponentEditionType::class,
                    'entry_options' => array(
                        'variation' => $this->variationResolver->resolve((new VariationContext())->denormalize(array(
                            'theme' => $options['theme'],
                            'content_type' => $options['content_type'],
                            'template_type' => $options['template_type'],
                            'zone_type' => $zone->getZoneType(),
                        ))),
                    ),
                ));

                // New component form widget
                $form->add('add_component', ComponentCreationType::class, array(
                    'auto_initialize' => false,
                    'mapped' => false,
                    'component_types' => $zone->getZoneType()->getAllowedComponentTypes(),
                ));
            })
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        // here data are not yet transformed, so form data is zone
        $zone = $form->getData();

        $view->vars['component_types'] = $zone->getZoneType()
            ->getAllowedComponentTypes()
                ->indexBy('id')
                ->map(function (ComponentTypeInterface $componentType) {
                    return $componentType->getName();
                })
        ;
        $view->vars['zone_id'] = $zone->getId();
    }

    /**
     * @see DataTransformerInterface::reverseTransform()
     */
    public function reverseTransform($data)
    {
        $data->resolve();

        return $data->getZone();
    }
}

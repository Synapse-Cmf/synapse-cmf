<?php

namespace Synapse\Cmf\Bundle\Form\Type\Theme;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Synapse\Cmf\Framework\Engine\Resolver\VariationResolver;
use Synapse\Cmf\Framework\Theme\ContentType\Model\ContentTypeInterface;
use Synapse\Cmf\Framework\Theme\TemplateType\Model\TemplateTypeInterface;
use Synapse\Cmf\Framework\Theme\Template\Action\Dal\UpdateAction;
use Synapse\Cmf\Framework\Theme\Template\Domain\Action\ActionDispatcherDomain as TemplateDomain;
use Synapse\Cmf\Framework\Theme\Template\Model\TemplateInterface;
use Synapse\Cmf\Framework\Theme\Theme\Model\ThemeInterface;
use Synapse\Cmf\Framework\Theme\Variation\Entity\Variation;
use Synapse\Cmf\Framework\Theme\Variation\Entity\VariationContext;
use Synapse\Cmf\Framework\Theme\ZoneType\Model\ZoneTypeInterface;

/**
 * Custom form type for template use cases.
 */
class TemplateType extends AbstractType implements DataTransformerInterface
{
    /**
     * @var TemplateDomain
     */
    protected $templateDomain;

    /**
     * @var VariationResolver
     */
    protected $variationResolver;

    /**
     * Construct.
     *
     * @param TemplateDomain    $templateDomain
     * @param VariationResolver $variationResolver
     */
    public function __construct(TemplateDomain $templateDomain, VariationResolver $variationResolver)
    {
        $this->templateDomain = $templateDomain;
        $this->variationResolver = $variationResolver;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('theme');
        $resolver->setAllowedTypes('theme', ThemeInterface::class);

        $resolver->setRequired('template_type');
        $resolver->setAllowedTypes('template_type', TemplateTypeInterface::class);

        $resolver->setRequired('content_type');
        $resolver->setAllowedTypes('content_type', ContentTypeInterface::class);

        $resolver->setRequired('variation');
        $resolver->setAllowedTypes('variation', Variation::class);
        $resolver->setDefault('variation', function (Options $options) {
            return $this->variationResolver->resolve((new VariationContext())->denormalize(array(
                'theme' => $options['theme'],
                'content_type' => $options['content_type'],
                'template_type' => $options['template_type'],
            )));
        });

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
        if ($data instanceof TemplateInterface) {
            return $this->templateDomain->getAction('update', $data);
        }

        throw new TransformationFailedException(sprintf(
            'Template edition type only supports template or template update action. "%s" given.',
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
        $templateType = $options['template_type'];
        $variation = $options['variation'];

        $builder
            ->addModelTransformer($this)

            // build template zones
            ->add('zones', CollectionType::class, array(
                'allow_add' => false,
                'allow_delete' => false,
                'entry_type' => ZoneType::class,
                'entry_options' => array(
                    'theme' => $options['theme'],
                    'content_type' => $options['content_type'],
                    'template_type' => $options['template_type'],
                ),
            ))

            // zone type selection (unmapped, frontend use case - should be defined in Twig layout ?)
            ->add('zone_types', ChoiceType::class, array(
                'mapped' => false,
                'required' => true,
                'expanded' => false,
                'choices' => $templateType->getZoneTypes()->indexBy('name'),
                'choice_value' => 'name',
                'choice_label' => 'name',

                // main zone by default
                'data' => $templateType->getZoneTypes()
                    ->filter(function (ZoneTypeInterface $zoneType) use ($variation) {
                        return $variation->getConfiguration(
                            'zones', $zoneType->getName(), 'main', false
                        );
                    })
                    ->first() ?: null,
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    // public function buildView(FormView $view, FormInterface $form, array $options)
    // {
    //     $view->vars['template_name'] = $options['template_type']->getName();
    // }

    /**
     * @see DataTransformerInterface::reverseTransform()
     */
    public function reverseTransform($data)
    {
        return $data->resolve();
    }
}

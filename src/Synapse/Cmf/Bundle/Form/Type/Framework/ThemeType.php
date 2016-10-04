<?php

namespace Synapse\Cmf\Bundle\Form\Type\Framework;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Synapse\Cmf\Bundle\Form\Mapper\TemplateActionCollection;
use Synapse\Cmf\Framework\Engine\Resolver\VariationResolver;
use Synapse\Cmf\Framework\Theme\Content\Entity\Content;
use Synapse\Cmf\Framework\Theme\Theme\Model\ThemeInterface;
use Synapse\Cmf\Framework\Theme\Variation\Entity\VariationContext;

/**
 * Form type for synapse theme edition
 * Build dynamic template forms from given options.
 */
class ThemeType extends AbstractType implements DataTransformerInterface
{
    /**
     * @var VariationResolver
     */
    protected $variationResolver;

    /**
     * Construct.
     *
     * @param VariationResolver $variationResolver
     */
    public function __construct(VariationResolver $variationResolver)
    {
        $this->variationResolver = $variationResolver;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('theme');
        $resolver->setAllowedTypes('theme', array(ThemeInterface::class));

        $resolver->setRequired('content');
        $resolver->setAllowedTypes('content', Content::class);

        $resolver->setDefaults(array(
            'cascade_validation' => false,
        ));
    }

    /**
     * @see DataTransformerInterface::transform()
     */
    public function transform($data)
    {
        return $data;
    }

    /**
     * Theme form prototype definition.
     *
     * @see FormInterface::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addModelTransformer($this)
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($builder, $options) {
                $form = $event->getForm();
                $data = array(
                    'template_types' => null,
                    'templates' => array(),
                );

                // "templates"  field
                $templateFormBuilder = $builder->create('templates', null, array(
                    'compound' => true,
                    'auto_initialize' => false,
                ));
                $templateTypeChoices = array();

                // every template type got his own form
                foreach ($options['theme']->getTemplateTypes() as $templateType) {

                    // variation calculation
                    $variation = $this->variationResolver->resolve((new VariationContext())->denormalize(array(
                        'theme' => $options['theme'],
                        'content_type' => $contentType = $options['content']->getType(),
                        'template_type' => $templateType,
                    )));
                    if (!$templateType->supportsContentType(
                        $contentType->getName(),
                        $variation->getConfiguration('templates', $templateType->getName(), 'contents', array())
                    )) {
                        continue;
                    }

                    $templateFormBuilder->add($templateType->getName(), TemplateType::class, array(
                        'auto_initialize' => false,
                        'variation' => $variation,
                        'template_type' => $templateType,
                        'theme' => $options['theme'],
                        'content' => $options['content'],
                    ));
                    $data['templates'][$templateType->getName()] = array();

                    // template select entry
                    $templateTypeChoices[$templateType->getId()] = $templateType;
                }

                $form
                    ->add('template_types', ChoiceType::class, array(
                        'required' => true,
                        'expanded' => false,
                        'auto_initialize' => false,
                        'choices' => $templateTypeChoices,
                        'mapped' => false,
                        'choice_value' => 'name',
                        'choice_label' => 'name',
                    ))
                    ->add($templateFormBuilder->getForm())
                ;

                $event->setData($data);
            })
        ;
    }

    /**
     * @see DataTransformerInterface::reverseTransform()
     */
    public function reverseTransform($data)
    {
        return new TemplateActionCollection($data['templates']);
    }
}

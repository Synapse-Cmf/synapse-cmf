<?php

namespace Synapse\Cmf\Bundle\Form\Type\Theme;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Synapse\Cmf\Bundle\Form\Mapper\TemplateActionCollection;
use Synapse\Cmf\Framework\Engine\Resolver\VariationResolver;
use Synapse\Cmf\Framework\Theme\ContentType\Model\ContentTypeInterface;
use Synapse\Cmf\Framework\Theme\Content\Entity\Content;
use Synapse\Cmf\Framework\Theme\Template\Loader\LoaderInterface as TemplateLoader;
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
     * @var TemplateLoader
     */
    protected $templateLoader;

    /**
     * Construct.
     *
     * @param VariationResolver $variationResolver
     * @param TemplateLoader    $templateLoader
     */
    public function __construct(VariationResolver $variationResolver, TemplateLoader $templateLoader)
    {
        $this->variationResolver = $variationResolver;
        $this->templateLoader = $templateLoader;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('theme');
        $resolver->setAllowedTypes('theme', array(ThemeInterface::class));

        $resolver->setDefaults(array(
            'content' => null,
            'cascade_validation' => false,
        ));
        $resolver->setAllowedTypes('content', array('null', Content::class));

        $resolver->setRequired('content_type');
        $resolver->setAllowedTypes('content_type', array(ContentTypeInterface::class));

        $resolver->setDefault('content_type', function (Options $options) {
            return $options['content'] ? $options['content']->getType() : null;
        });
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
                        'content_type' => $contentType = $options['content_type'],
                        'template_type' => $templateType,
                    )));
                    if (!$templateType->supportsContentType(
                        $contentType->getName(),
                        $variation->getConfiguration('templates', $templateType->getName(), 'contents', array())
                    )) {
                        continue;
                    }

                    // template select entry
                    $templateTypeChoices[$templateType->getId()] = $templateType;

                    // template form construction
                    $template = $options['content']
                        ? $this->templateLoader->retrieveLocal($templateType, $options['content'])
                        : $this->templateLoader->retrieveGlobal($templateType, $contentType)
                    ;
                    if (!$template) {  // no template to edit : nothing to do
                        continue;
                    }

                    $data['templates'][$templateType->getName()] = $template;

                    $templateFormBuilder->add($templateType->getName(), TemplateType::class, array(
                        'auto_initialize' => false,
                        'content_type' => $options['content_type'],
                        'theme' => $options['theme'],
                        'template_type' => $templateType,
                        'variation' => $variation,
                    ));
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
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        // build template init map
        $templatesInitMap = array();
        foreach ($options['theme']->getTemplateTypes() as $templateType) {
            if ($form->get('templates')->has($templateType->getName())) {
                continue;
            }

            $templatesInitMap[$templateType->getName()] = array(
                'template_type_id' => $templateType->getId(),
                'content_type' => $options['content_type']->getId(),
                'content_id' => $options['content'] ? $options['content']->getContentId() : null,
            );
        }

        $view->vars['templates_init_map'] = $templatesInitMap;
    }

    /**
     * @see DataTransformerInterface::reverseTransform()
     */
    public function reverseTransform($data)
    {
        // create a proxy collection for actions to resolve on demand, triggered by caller
        return new TemplateActionCollection($data['templates']);
    }
}

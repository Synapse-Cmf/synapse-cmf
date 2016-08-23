<?php

namespace Synapse\Cmf\Bundle\Form\Type\Framework\Template;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Synapse\Cmf\Framework\Theme\ContentType\Loader\LoaderInterface as ContentTypeLoader;
use Synapse\Cmf\Framework\Theme\ContentType\Model\ContentTypeInterface;
use Synapse\Cmf\Framework\Theme\TemplateType\Loader\LoaderInterface as TemplateTypeLoader;
use Synapse\Cmf\Framework\Theme\TemplateType\Model\TemplateTypeInterface;
use Synapse\Cmf\Framework\Theme\Template\Action\AbstractAction as TemplateAction;
use Synapse\Cmf\Framework\Theme\Template\Action\Dal\CreateGlobalAction;
use Synapse\Cmf\Framework\Theme\Template\Domain\Action\ActionDispatcherDomain as TemplateDomain;

/**
 * Defines a global template creation type form.
 */
class GlobalCreationType extends AbstractType implements DataTransformerInterface
{
    /**
     * @var TemplateDomain
     */
    protected $templateDomain;

    /**
     * @var ContentTypeLoader
     */
    protected $contentTypeLoader;

    /**
     * @var TemplateTypeLoader
     */
    protected $templateTypeLoader;

    /**
     * Construct.
     *
     * @param TemplateDomain     $templateDomain
     * @param ContentTypeLoader  $contentTypeLoader
     * @param TemplateTypeLoader $templateTypeLoader
     */
    public function __construct(
        TemplateDomain $templateDomain,
        ContentTypeLoader $contentTypeLoader,
        TemplateTypeLoader $templateTypeLoader
    ) {
        $this->templateDomain = $templateDomain;
        $this->contentTypeLoader = $contentTypeLoader;
        $this->templateTypeLoader = $templateTypeLoader;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'cascade_validation' => false,
            'data_class' => CreateGlobalAction::class,
        ));
    }

    /**
     * @see DataTransformerInterface::transform()
     */
    public function transform($data)
    {
        return $data instanceof CreateGlobalAction
            ? $data
            : $this->templateDomain->getAction('create_global')
        ;
    }

    /**
     * @see FormInterface::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addModelTransformer($this)
            ->add('content_type', ChoiceType::class, array(
                'required' => true,
                'expanded' => false,
                'choices' => $this->contentTypeLoader->retrieveAll(),
                'choice_label' => function ($value, $key, $index) {
                    return $value instanceof ContentTypeInterface ?
                        $value->getName() :
                        $key
                    ;
                },
            ))
            ->add('template_type', ChoiceType::class, array(
                'required' => true,
                'expanded' => false,
                'choices' => $this->templateTypeLoader->retrieveAll(),
                'choice_label' => function ($value, $key, $index) {
                    return $value instanceof TemplateTypeInterface ?
                        $value->getName() :
                        $key
                    ;
                },
            ))
        ;
    }

    /**
     * @see DataTransformerInterface::reverseTransform()
     */
    public function reverseTransform($data)
    {
        return $data instanceof TemplateAction
            ? $data->resolve()
            : $data
        ;
    }
}

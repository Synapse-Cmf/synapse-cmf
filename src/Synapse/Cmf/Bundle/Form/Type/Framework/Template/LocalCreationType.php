<?php

namespace Synapse\Cmf\Bundle\Form\Type\Framework\Template;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Synapse\Cmf\Framework\Theme\Content\Entity\Content;
use Synapse\Cmf\Framework\Theme\TemplateType\Model\TemplateTypeInterface;
use Synapse\Cmf\Framework\Theme\Template\Domain\Action\ActionDispatcherDomain as TemplateDomain;

/**
 * Defines a local template creation type form.
 */
class LocalCreationType extends AbstractType implements DataTransformerInterface
{
    /**
     * @var TemplateDomain
     */
    protected $templateDomain;

    /**
     * Construct.
     *
     * @param TemplateDomain $templateDomain
     */
    public function __construct(TemplateDomain $templateDomain)
    {
        $this->templateDomain = $templateDomain;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'content' => null,
            'template_type' => null,
            'cascade_validation' => false,
        ));

        $resolver->setAllowedTypes('content', array('null', Content::class));
        $resolver->setAllowedTypes('template_type', array('null', TemplateTypeInterface::class));
    }

    /**
     * @see DataTransformerInterface::transform()
     */
    public function transform($data)
    {
        return $data;
    }

    /**
     * @see FormInterface::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addModelTransformer($this)
            ->add('trigger_initialization', CheckboxType::class, array(
                'required' => false,
            ))
            ->add('content', ChoiceType::class, array(
                'required' => true,
                'choices' => empty($options['content'])
                    ? array()
                    : array($options['content']->getContentId() => $options['content']),
            ))
            ->add('template_type', ChoiceType::class, array(
                'required' => true,
                'choices' => empty($options['template_type'])
                    ? array()
                    : array($options['template_type']->getId() => $options['template_type']),
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['content_type'] = empty($options['content']) ? '' :
            $options['content']->getType()->getName()
        ;
        $view->vars['template_type'] = empty($options['template_type']) ? '' :
            $options['template_type']->getName()
        ;
        $view->vars['mode'] = 'create';
    }

    /**
     * @see DataTransformerInterface::reverseTransform()
     */
    public function reverseTransform($data)
    {
        return empty($data['trigger_initialization']) ? null :
            $this->templateDomain->createLocal(
                $data['content']->unwrap(),
                $data['template_type']
            )
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'template_creation';
    }
}

<?php

namespace Synapse\Cmf\Bundle\Form\Type\Framework\Template;

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
use Synapse\Cmf\Bundle\Form\Type\Framework\ZoneType;
use Synapse\Cmf\Framework\Theme\ContentType\Model\ContentTypeInterface;
use Synapse\Cmf\Framework\Theme\Template\Action\Dal\UpdateAction;
use Synapse\Cmf\Framework\Theme\Template\Domain\Action\ActionDispatcherDomain as TemplateDomain;
use Synapse\Cmf\Framework\Theme\Template\Model\TemplateInterface;
use Synapse\Cmf\Framework\Theme\Theme\Model\ThemeInterface;

/**
 * Template edition form type.
 */
class EditionType extends AbstractType implements DataTransformerInterface
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
        $resolver->setRequired('theme');
        $resolver->setAllowedTypes('theme', ThemeInterface::class);

        $resolver->setRequired('content_type');
        $resolver->setAllowedTypes('content_type', ContentTypeInterface::class);

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
        $builder
            ->addModelTransformer($this)
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($builder, $options) {
                $form = $event->getForm();
                $template = $event->getData();

                $form->add('zones', CollectionType::class, array(
                    'auto_initialize' => false,
                    'allow_add' => false,
                    'allow_delete' => false,
                    'entry_type' => ZoneType::class,
                    'entry_options' => array(
                        'theme' => $options['theme'],
                        'content_type' => $options['content_type'],
                        'template_type' => $template->getTemplateType(),
                    ),
                ));
            })
        ;
    }

    /**
     * @see DataTransformerInterface::reverseTransform()
     */
    public function reverseTransform($data)
    {
        return $data->resolve();
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['mode'] = 'edit';
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'template_edition';
    }
}

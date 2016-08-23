<?php

namespace Synapse\Cmf\Bundle\Form\Type\Framework\Component;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Synapse\Cmf\Framework\Theme\Component\Action\Dal\UpdateAction;
use Synapse\Cmf\Framework\Theme\Component\Domain\Action\ActionDispatcherDomain as ComponentDomain;
use Synapse\Cmf\Framework\Theme\Component\Model\ComponentInterface;

/**
 * Component edition form type.
 */
class EditionType extends AbstractType implements DataTransformerInterface
{
    /**
     * @var ComponentDomain
     */
    protected $componentDomain;

    /**
     * Construct.
     *
     * @param ComponentDomain $componentDomain
     */
    public function __construct(ComponentDomain $componentDomain)
    {
        $this->componentDomain = $componentDomain;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('component_options');
        $resolver->setAllowedTypes('component_options', 'array');

        $resolver->setDefaults(array(
            'mapped' => false,
            'cascade_validation' => false,
            'data_class' => UpdateAction::class,
        ));
    }

    /**
     * @see DataTransformerInterface::transform()
     */
    public function transform($data)
    {
        if (empty($data)) {
            return;
        }
        if ($data instanceof UpdateAction) {
            return $data;
        }
        if ($data instanceof ComponentInterface) {
            return $this->componentDomain->getAction('update', $data);
        }

        throw new TransformationFailedException(sprintf(
            'Component edition type only supports component or component update action. "%s" given.',
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
                if (!$component = $event->getData()) {
                    return;
                }

                $form = $event->getForm();

                // build custom "data" component form using component type defined form
                $form->add($builder
                    ->create('data', $component->getComponentType()->getFormType(), array_replace_recursive(
                        $options['component_options'],
                        array('auto_initialize' => false, 'label' => false)
                    ))
                    ->getForm()
                );
            })
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['component_id'] = $form->getData()->getId();
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
    public function getBlockPrefix()
    {
        return 'component_edition';
    }
}

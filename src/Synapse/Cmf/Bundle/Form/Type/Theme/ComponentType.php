<?php

namespace Synapse\Cmf\Bundle\Form\Type\Theme;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Synapse\Cmf\Framework\Theme\Component\Command\UpdateCommand;
use Synapse\Cmf\Framework\Theme\Component\Domain\Action\ActionDispatcherDomain as ComponentDomain;
use Synapse\Cmf\Framework\Theme\Component\Model\ComponentInterface;
use Synapse\Cmf\Framework\Theme\Variation\Entity\Variation;

/**
 * Component edition form type.
 */
class ComponentType extends AbstractType implements DataTransformerInterface
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
        $resolver->setRequired('variation');
        $resolver->setAllowedTypes('variation', Variation::class);

        $resolver->setDefaults(array(
            'data_class' => UpdateCommand::class,
        ));
    }

    /**
     * @see DataTransformerInterface::transform()
     */
    public function transform($data)
    {
        if ($data instanceof UpdateCommand) {
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
                $form = $event->getForm();
                $component = $event->getData();

                // Adds custom "data" component from component type
                $form->add('data', $component->getComponentType()->getFormType(), array_replace_recursive(
                    $options['variation']->getConfiguration(
                        'components',
                        $component->getComponentType()->getName(),
                        'config',
                        array()
                    ),
                    array(
                        'auto_initialize' => false,
                        'label' => false,
                    )
                ));
            })
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $component = $form->getData();

        $view->vars['label'] = ucfirst($component->getComponentType()->getName());
        $view->vars['component_id'] = $component->getId();
    }

    /**
     * @see DataTransformerInterface::reverseTransform()
     */
    public function reverseTransform($data)
    {
        $data->resolve();

        return $data->getComponent();
    }
}

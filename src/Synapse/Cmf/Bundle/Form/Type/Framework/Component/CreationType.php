<?php

namespace Synapse\Cmf\Bundle\Form\Type\Framework\Component;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Synapse\Cmf\Framework\Theme\ComponentType\Entity\ComponentTypeCollection;
use Synapse\Cmf\Framework\Theme\ComponentType\Loader\LoaderInterface as ComponentTypeLoader;
use Synapse\Cmf\Framework\Theme\Component\Action\Dal\CreateAction;
use Synapse\Cmf\Framework\Theme\Component\Domain\Action\ActionDispatcherDomain as ComponentDomain;

/**
 * Component creation form type.
 */
class CreationType extends AbstractType implements DataTransformerInterface
{
    /**
     * @var ComponentDomain
     */
    protected $componentDomain;

    /**
     * @var ComponentTypeLoader;
     */
    protected $componentTypeLoader;

    /**
     * Construct.
     *
     * @param ComponentDomain     $componentDomain
     * @param ComponentTypeLoader $componentTypeLoader
     */
    public function __construct(ComponentDomain $componentDomain, ComponentTypeLoader $componentTypeLoader)
    {
        $this->componentDomain = $componentDomain;
        $this->componentTypeLoader = $componentTypeLoader;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('component_types');
        $resolver->setAllowedTypes('component_types', ComponentTypeCollection::class);

        $resolver->setDefaults(array(
            'cascade_validation' => false,
            'data_class' => CreateAction::class,
        ));
    }

    /**
     * @see DataTransformerInterface::transform()
     */
    public function transform($data)
    {
        if ($data instanceof CreateAction) {
            return $data;
        }

        return $this->componentDomain->getAction('create', $data);
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
            ->add('component_type', ChoiceType::class, array(
                'required' => false,
                'expanded' => false,
                'label' => false,
                'placeholder' => 'choose component type',
                'choices' => $options['component_types']->indexBy('name'),
            ))
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
    public function getBlockPrefix()
    {
        return 'component_creation';
    }
}

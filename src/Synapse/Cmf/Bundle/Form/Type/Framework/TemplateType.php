<?php

namespace Synapse\Cmf\Bundle\Form\Type\Framework;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Synapse\Cmf\Bundle\Form\Type\Framework\Template\EditionType;
use Synapse\Cmf\Bundle\Form\Type\Framework\Template\LocalCreationType;
use Synapse\Cmf\Framework\Theme\Content\Entity\Content;
use Synapse\Cmf\Framework\Theme\TemplateType\Model\TemplateTypeInterface;
use Synapse\Cmf\Framework\Theme\Template\Loader\LoaderInterface as TemplateLoader;
use Synapse\Cmf\Framework\Theme\Theme\Model\ThemeInterface;
use Synapse\Cmf\Framework\Theme\Variation\Entity\Variation;
use Synapse\Cmf\Framework\Theme\ZoneType\Entity\ZoneType;

/**
 * Custom form type for template use cases.
 */
class TemplateType extends AbstractType
{
    /**
     * @var TemplateLoader
     */
    protected $templateLoader;

    /**
     * Construct.
     *
     * @param TemplateLoader $templateLoader
     */
    public function __construct(TemplateLoader $templateLoader)
    {
        $this->templateLoader = $templateLoader;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('theme');
        $resolver->setAllowedTypes('theme', array(ThemeInterface::class));

        $resolver->setRequired('template_type');
        $resolver->setAllowedTypes('template_type', TemplateTypeInterface::class);

        $resolver->setRequired('content');
        $resolver->setAllowedTypes('content', Content::class);

        $resolver->setRequired('variation');
        $resolver->setAllowedTypes('variation', Variation::class);
    }

    /**
     * Page form prototype definition.
     *
     * @see FormInterface::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($builder, $options) {
                $form = $event->getForm();
                $data = array(
                    'template' => array(),
                );

                $localTemplate = $this->templateLoader->retrieveLocal(
                    $templateType = $options['template_type'],
                    $content = $options['content']
                );

                if ($localTemplate) { // then edit form
                    $variation = $options['variation'];

                    // template edition form
                    $form->add('template', EditionType::class, array(
                        'auto_initialize' => false,
                        'theme' => $options['theme'],
                        'content_type' => $content->getType(),
                    ));
                    $data['template'] = $localTemplate;

                    // zone type selection
                    $form->add('zone_types', ChoiceType::class, array(
                        'auto_initialize' => false,
                        'mapped' => false,
                        'required' => true,
                        'expanded' => false,
                        'choices' => $templateType->getZoneTypes()->indexBy('name'),
                        'choice_value' => 'name',
                        'choice_label' => 'name',

                        // main zone by default
                        'data' => $templateType->getZoneTypes()
                            ->filter(function (ZoneType $zoneType) use ($variation) {
                                return $variation->getConfiguration(
                                    'zones', $zoneType->getName(), 'main', false
                                );
                            })
                            ->first() ?: null,
                    ));
                } else { // otherwise init form
                    $form->add('template', LocalCreationType::class, array(
                        'template_type' => $templateType,
                        'content' => $content,
                    ));
                }

                $event->setData($data);
            })
        ;
    }
}

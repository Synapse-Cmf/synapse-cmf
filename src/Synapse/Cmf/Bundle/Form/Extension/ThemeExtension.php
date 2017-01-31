<?php

namespace Synapse\Cmf\Bundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Synapse\Cmf\Bundle\Form\Type\Theme\ThemeType;
use Synapse\Cmf\Framework\Engine\Exception\InvalidThemeException;
use Synapse\Cmf\Framework\Theme\Content\Model\ContentInterface;
use Synapse\Cmf\Framework\Theme\Content\Resolver\ContentResolver;
use Synapse\Cmf\Framework\Theme\Theme\Entity\Theme;
use Synapse\Cmf\Framework\Theme\Theme\Loader\LoaderInterface as ThemeLoader;

/**
 * Form theme extension class which provide framework features
 * through simple options into all form types.
 *
 * @example template initialiation
 *    public function configureOptions(OptionsResolver $resolver)
 *    {
 *        // ...
 *        $resolver->setDefault(array(
 *            'synapse_theme' => 'demo'
 *        ));
 *    }
 *    // triggering (controller or ...)
 *    $content = $this->get('...')->save(
 *        $form->getData()
 *    );
 *    $form->get('synapse')->getData()->resolve();
 * @example template edition
 *    public function configureOptions(OptionsResolver $resolver)
 *    {
 *        // ...
 *        $resolver->setDefault(array(
 *            'synapse_theme' => 'demo'
 *        ));
 *    }
 */
class ThemeExtension extends AbstractTypeExtension
{
    /**
     * @var ThemeLoader
     */
    protected $themeLoader;

    /**
     * @var ContentResolver
     */
    protected $contentResolver;

    /**
     * Construct.
     *
     * @param ThemeLoader     $themeLoader
     * @param ContentResolver $contentResolver
     */
    public function __construct(
        ThemeLoader $themeLoader,
        ContentResolver $contentResolver
    ) {
        $this->themeLoader = $themeLoader;
        $this->contentResolver = $contentResolver;
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return FormType::class;
    }

    /**
     * {@inheritdoc}
     *
     * Using loaders as callback normalizer / default don't cause loader hydration
     * while synapse form isn't activated : perf matters !
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('synapse_form_options', array());

        $resolver->setDefined(array('synapse_theme'));
        $resolver->setNormalizer('synapse_theme', function (Options $options, $value) {
            switch (true) {
                case empty($value):
                    return $value;

                case $value instanceof Theme:
                    return $value;

                default:
                    if (!$theme = $this->themeLoader->retrieveByName($value)) {
                        throw new InvalidThemeException(sprintf(
                            'Theme "%s" not registered. Only %s are, check your configuration.',
                            $value,
                            $this->themeLoader->retrieveAll()->display('name')
                        ));
                    }

                    return $theme;
            }
        });
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (empty($options['synapse_theme'])) {
            return;
        }
        $builder
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($builder, $options) {
                $content = $event->getData();
                if (!$content instanceof ContentInterface) {
                    throw new \InvalidArgumentException(sprintf(
                        'Synapse forms only supports ContentInterfaces as data, "%s" given.',
                        is_object($content) ? get_class($content) : gettype($content)
                    ));
                }

                $event->getForm()->add('synapse', ThemeType::class, array_replace_recursive(
                    array('mapped' => false),
                    $options['synapse_form_options'],
                    array(
                        'compound' => true,
                        'auto_initialize' => false,
                        'theme' => $options['synapse_theme'],
                        'content' => $this->contentResolver->resolve($content),
                    )
                ));
            }, -255)
        ;
    }
}

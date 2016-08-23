<?php

namespace Synapse\Demo\Bundle\AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Synapse\Cmf\Bundle\Entity\Orm\Template;
use Synapse\Cmf\Framework\Theme\Component\Entity\ComponentCollection;
use Synapse\Cmf\Framework\Theme\Content\Entity\Content;
use Synapse\Cmf\Framework\Theme\Zone\Entity\ZoneCollection;
use Synapse\Page\Bundle\Entity\Page;

/**
 * Demo site fixtures loader.
 */
class DemoThemeFixturesLoader extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @see ContainerAwareInterface::setContainer()
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @see OrderedFixtureInterface::getOrder()
     */
    public function getOrder()
    {
        return 10;
    }

    /**
     * Register given data set into given domain.
     *
     * @param mixed $domain
     * @param mixed $dataset
     */
    private function registerData($domain, $dataset, $action = 'create')
    {
        foreach ($dataset as $reference => $data) {
            $this->addReference(
                $reference,
                $domain->getAction($action)
                    ->denormalize($data)
                    ->resolve()
            );
        }
    }

    /**
     * @see FixtureInterface::load()
     */
    public function load(ObjectManager $manager)
    {
        if (!$manager->getMetadataFactory()->hasMetadataFor(Template::class)) {
            return;
        }

        // components
        $componentTypeLoader = $this->container->get('synapse.component_type.loader');
        $componentDomain = $this->container->get('synapse.component.domain');

        $this->addReference('component_free_1', $componentDomain->create(
            $componentTypeLoader->retrieve('free'),
            array('html' => 'This is my jumbotroned Free 1 component.')
        ));
        $this->addReference('component_free_2', $componentDomain->create(
            $componentTypeLoader->retrieve('free'),
            array('html' => 'This is my <span style="font-style: italic;">Free 2</span> component.')
        ));
        $this->addReference('component_free_3', $componentDomain->create(
            $componentTypeLoader->retrieve('free'),
            array('html' => 'This is my <span style="text-decoration: underline;">Free 3</span> component.')
        ));
        $this->addReference('component_free_4', $componentDomain->create(
            $componentTypeLoader->retrieve('free'),
            array('html' => 'This is my <span style="font-weight: bold;">Free 4</span> component.')
        ));

        // zones
        $zoneTypeLoader = $this->container->get('synapse.zone_type.loader');
        $zoneDomain = $this->container->get('synapse.zone.domain');

        $this->addReference('zone_jumbotron_1', $zoneDomain->create(
            $zoneTypeLoader->retrieve('bootstrap.page.jumbotron'),
            new ComponentCollection(array(
                $this->getReference('component_free_1'),
            ))
        ));
        $this->addReference('zone_content_1', $zoneDomain->create(
            $zoneTypeLoader->retrieve('bootstrap.page.content'),
            new ComponentCollection(array(
                $this->getReference('component_free_2'),
                $this->getReference('component_free_3'),
                $this->getReference('component_free_4'),
            ))
        ));

        // templates
        $templateTypeLoader = $this->container->get('synapse.template_type.loader');
        $contentTypeLoader = $this->container->get('synapse.content_type.loader');
        $templateDomain = $this->container->get('synapse.template.domain');

        $this->addReference('template_page', $templateDomain->createGlobal(
            $contentTypeLoader->retrieve('page'),
            $templateTypeLoader->retrieve('bootstrap.page'),
            new ZoneCollection(array(
                $this->getReference('zone_jumbotron_1'),
                $this->getReference('zone_content_1'),
            ))
        ));
    }
}

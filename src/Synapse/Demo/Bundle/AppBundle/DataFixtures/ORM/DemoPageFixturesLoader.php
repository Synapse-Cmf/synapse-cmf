<?php

namespace Synapse\Demo\Bundle\AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Synapse\Page\Bundle\Entity\Page;

/**
 * Demo site fixtures loader.
 */
class DemoPageFixturesLoader extends AbstractFixture implements ContainerAwareInterface, OrderedFixtureInterface
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
        return 1;
    }

    /**
     * @see FixtureInterface::load()
     */
    public function load(ObjectManager $manager)
    {
        if (!$manager->getMetadataFactory()->hasMetadataFor(Page::class)) {
            return;
        }

        $pageDomain = $this->container->get('synapse.page.domain');

        $this->addReference(
            'homepage',
            $homepage = $pageDomain->create('Homepage', null, '', true)
        );
        $this->addReference(
            'esport',
            $esport = $pageDomain->create('e-Sport', $homepage, 'e-Sport', true)
        );
        $this->addReference(
            'league_of_legends',
            $lol = $pageDomain->create('League of Legends', $esport, 'League of Legends', true)
        );
    }
}

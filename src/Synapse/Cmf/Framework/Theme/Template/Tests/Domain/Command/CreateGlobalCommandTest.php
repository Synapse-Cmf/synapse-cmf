<?php

namespace Synapse\Cmf\Framework\Theme\Template\Tests\Domain\Command;

use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Synapse\Cmf\Framework\Theme\ContentType\Entity\ContentType;
use Synapse\Cmf\Framework\Theme\TemplateType\Entity\TemplateType;
use Synapse\Cmf\Framework\Theme\Template\Domain\Command\CreateGlobalCommand;
use Synapse\Cmf\Framework\Theme\Template\Entity\Template;
use Synapse\Cmf\Framework\Theme\Template\Event\Event;
use Synapse\Cmf\Framework\Theme\Template\Event\Events;
use Synapse\Cmf\Framework\Theme\Zone\Domain\DomainInterface;
use Synapse\Cmf\Framework\Theme\Zone\Entity\Zone;
use Synapse\Cmf\Framework\Theme\Zone\Entity\ZoneCollection;

/**
 * Unit test class for global Component creation command.
 */
class CreateGlobalCommandTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests global template creation command.
     */
    public function testResolve()
    {
        // Validator
        $validator = $this->prophesize(ValidatorInterface::class);
        $validator->validate(Argument::type(Template::class), null, array('Template', 'creation'))
            ->shouldBeCalled()
        ;

        // Event dispatcher
        $eventDispatcher = $this->prophesize(EventDispatcherInterface::class);
        $eventDispatcher->addListener(Events::TEMPLATE_CREATED, Argument::type('array'))
            ->shouldBeCalled()
        ;
        $eventDispatcher->dispatch(Events::TEMPLATE_CREATED, Argument::type(Event::class))
            ->shouldBeCalled()
        ;
        $eventDispatcher->removeListener(Events::TEMPLATE_CREATED, Argument::type('array'))
            ->shouldBeCalled()
        ;

        // Command
        $command = new CreateGlobalCommand(Template::class);
        $command->setZoneDomain($this->prophesize(DomainInterface::class)->reveal());
        $command->setValidator($validator->reveal());
        $command->setEventDispatcher($eventDispatcher->reveal());

        $command->setZones($zoneCollection = new ZoneCollection(array(
            new Zone(), new Zone(), new Zone(),
        )));
        $command->setTemplateType($templateType = new TemplateType());
        $command->setContentType($contentType = new ContentType());

        $this->assertInstanceOf(Template::class, $template = $command->resolve());
        $this->assertEquals($templateType, $template->getTemplateType());
        $this->assertEquals($contentType, $template->getContentType());
    }
}

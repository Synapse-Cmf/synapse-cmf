<?php

namespace Synapse\Cmf\Framework\Media\File\Tests\Action\Dal;

use Synapse\Cmf\Framework\Media\File\Action\Dal\CreateAction;
use Synapse\Cmf\Framework\Media\File\Entity\File;
use Synapse\Cmf\Framework\Media\File\Event\Event;
use Synapse\Cmf\Framework\Media\File\Event\Events;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Unit test class for File CreateAction throught Dal.
 */
class CreateActionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Provides use cases to resolve() function tests.
     *
     * @example
     *     array(
     *         'incomming data',
     *         'expected_file'
     *     )
     *
     * @return array()
     */
    public function resolvingCasesProvider()
    {
        return array(
            'no_extra_fields_given' => array(
                array(),
                new File(),
            ),
        );
    }

    /**
     * Tests resolve() function.
     *
     * @dataProvider resolvingCasesProvider
     */
    public function testResolve(
        array $incommingData,
        File $expectedFile
    ) {
        // Validator
        $validator = $this->prophesize(ValidatorInterface::class);
        $validator
            ->validate(
                Argument::type(File::class),
                null,
                array('File', 'creation')
            )
            ->shouldBeCalled()
        ;

        // Event dispatcher
        $eventDispatcher = $this->prophesize(EventDispatcherInterface::class);
        $eventDispatcher
            ->dispatch(
                Events::FILE_CREATED,
                Argument::type(Event::class)
            )
            ->shouldBeCalled()
        ;

        // Action
        $action = new CreateAction();
        $action->setEventDispatcher($eventDispatcher->reveal());
        $action->setValidator($validator->reveal());
        $action->denormalize($incommingData);
        $action->resolve();

        $this->assertEquals(
            $expectedFile,
            $action->getFile()
        );
    }
}

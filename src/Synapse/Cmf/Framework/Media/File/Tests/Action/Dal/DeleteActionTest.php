<?php

namespace Synapse\Cmf\Framework\Media\File\Tests\Action\Dal;

use Synapse\Cmf\Framework\Media\File\Action\Dal\DeleteAction;
use Synapse\Cmf\Framework\Media\File\Entity\File;
use Synapse\Cmf\Framework\Media\File\Event\Event;
use Synapse\Cmf\Framework\Media\File\Event\Events;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Unit test class for File DeleteAction throught Dal.
 */
class DeleteActionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Provides use cases to resolve() function tests.
     *
     * @example
     *     array(
     *         "given_file"
     *     )
     *
     * @return array()
     */
    public function resolvingCasesProvider()
    {
        return array(
            'default_case' => array(
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
        File $givenFile
    ) {
        $asserter = $this;

        // Event dispatcher
        $eventDispatcher = $this->prophesize(EventDispatcherInterface::class);
        $eventDispatcher
            ->dispatch(
                Events::FILE_DELETED,
                Argument::type(Event::class)
            )
            ->will(function ($args) use ($asserter, $givenFile) {
                $asserter->assertEquals(
                    $givenFile,
                    $args[1]->getFile()
                );
            })
            ->shouldBeCalled()
        ;

        // Action
        $action = new DeleteAction();
        $action->setEventDispatcher($eventDispatcher->reveal());
        $action->init($givenFile);

        $action->resolve();
    }
}

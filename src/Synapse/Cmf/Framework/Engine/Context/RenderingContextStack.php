<?php

namespace Synapse\Cmf\Framework\Engine\Context;

use Synapse\Cmf\Framework\Engine\Context\Content\RenderingContext;

/**
 * Stack of rendering contexts, used to handle context nesting
 * between content and components.
 */
final class RenderingContextStack
{
    /**
     * Materialize an empty stack : no context registered.
     */
    const VOID = 'rendering_context.empty';

    /**
     * Materialize a stack level with an active content context.
     */
    const CONTENT = 'rendering_context.template';

    /**
     * Materialize a stack level with an active component context.
     */
    const COMPONENT = 'rendering_context.component';

    /**
     * @var RenderingContext[]
     */
    private $stack;

    /**
     * Construct.
     */
    public function __construct()
    {
        $this->stack = array();
    }

    /**
     * Returns current RenderingContext.
     *
     * @return RenderingContext
     *
     * @throws BadMethodCallException If any rendering context registered
     */
    public function getCurrent()
    {
        if (empty($this->stack)) {
            throw new \BadMethodCallException(
                'Any rendering context available. Please add one throught push method before request current one.'
            );
        }

        return reset($this->stack);
    }

    /**
     * Returns level of stack (0 is empty, 1 is master context, 2 for zone contexts).
     *
     * @return int
     */
    public function getLevel()
    {
        $constMap = array(
            self::VOID,
            self::CONTENT,
            self::COMPONENT,
        );

        return $constMap[count($this->stack)];
    }

    /**
     * Push given context over the stack, making it the current one.
     *
     * @param RenderingContext $context
     *
     * @return self
     *
     * @throws BadMethodCallException If stack is full
     */
    public function push(RenderingContext $context)
    {
        if ($this->getLevel() == self::COMPONENT) {
            throw new \BadMethodCallException(
                'Cannot push another context : stack is full. Resolve or flush current one first'
            );
        }

        array_unshift($this->stack, $context);

        return $this;
    }

    /**
     * Pop the context over the stack.
     *
     * @return self
     *
     * @throws BadMethodCallException If any rendering context in the stack
     */
    public function pop()
    {
        if (empty($this->stack)) {
            throw new \BadMethodCallException(
                'The stack is empty, it cannot be popped. Please check if pop() hasnt been called before this one.'
            );
        }

        array_shift($this->stack);

        return $this;
    }
}

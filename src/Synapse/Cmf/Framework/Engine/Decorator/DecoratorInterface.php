<?php

namespace Synapse\Cmf\Framework\Engine\Decorator;

/**
 * Interface to implement on Synapse decorators.
 */
interface DecoratorInterface
{
    /**
     * Renders Synapse current context as a string from given parameters.
     *
     * @param array $templateParameters
     *
     * @return string
     */
    public function render(array $templateParameters = array());

    /**
     * Renders Synapse current context as a Http response from given parameters.
     *
     * @param array $templateParameters
     *
     * @return Response
     */
    public function decorate(array $templateParameters = array());
}

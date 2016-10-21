<?php

namespace Synapse\Cmf\Framework\Theme\Variation\Entity;

use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

/**
 * Variation value object class, handle config distribution.
 */
class Variation
{
    /**
     * @var array
     */
    protected $configurations;

    /**
     * @var PropertyAccessorInterface
     */
    protected $propertyAccessor;

    /**
     * Construct.
     *
     * @param array                     $configurations
     * @param PropertyAccessorInterface $propertyAccessor
     */
    public function __construct(array $configurations, PropertyAccessorInterface $propertyAccessor)
    {
        $this->configurations = $configurations;
        $this->propertyAccessor = $propertyAccessor;
    }

    /**
     * Return configuration value under given property path into given namespace or default if not readable.
     *
     * @see PropertyAccessorInterface::getValue()
     *
     * @param sgring $namespace
     * @param string $path
     * @param string $element
     * @param mixed  $default
     *
     * @return mixed
     */
    public function getConfiguration($namespace, $element, $key, $default = null)
    {
        $propertyPath = sprintf('[%s][%s][%s]', $namespace, $element, $key);

        if ($value = $this->propertyAccessor->getValue($this->configurations, $propertyPath)) {
            return $value;
        }

        return $default;
    }
}

<?php

namespace Synapse\Page\Bundle\Form\Page;

use Symfony\Component\Form\AbstractType as SymfonyAbstractType;
use Symfony\Component\Form\DataTransformerInterface;
use Synapse\Page\Bundle\Action\AbstractAction as PageAction;
use Synapse\Page\Bundle\Domain\Action\ActionDispatcherDomain as PageDomain;

/**
 * Page entity use cases form dedicated abstract type.
 */
abstract class AbstractType extends SymfonyAbstractType implements DataTransformerInterface
{
    /**
     * @var PageDomain
     */
    protected $pageDomain;

    /**
     * Construct.
     *
     * @param PageDomain $pageDomain
     */
    public function __construct(PageDomain $pageDomain)
    {
        $this->pageDomain = $pageDomain;
    }

    /**
     * @see DataTransformerInterface::reverseTransform()
     */
    public function reverseTransform($data)
    {
        return $data instanceof PageAction
            ? $data->resolve()
            : $data
        ;
    }
}

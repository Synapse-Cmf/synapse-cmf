<?php

namespace Synapse\Page\Bundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Synapse\Page\Bundle\Action\Page\AbstractAction;
use Synapse\Page\Bundle\Action\Page\CreateAction;
use Synapse\Page\Bundle\Entity\Page;
use Synapse\Page\Bundle\Loader\Page\LoaderInterface as PageLoader;

/**
 * Validator class for UniquePagePath constraint, checks into persistence if
 * given page path already exists or not.
 */
class UniquePagePathValidator extends ConstraintValidator
{
    /**
     * @var PageLoader
     */
    protected $pageLoader;

    /**
     * Construct.
     *
     * @param PageLoader $pageLoader
     */
    public function __construct(PageLoader $pageLoader)
    {
        $this->pageLoader = $pageLoader;
    }

    /**
     * Validate given page path is unique.
     * Works with page create action too.
     *
     * @param Page       $page
     * @param Constraint $constraint
     */
    public function validate($page, Constraint $constraint)
    {
        if (!$page instanceof CreateAction && !$page instanceof Page) {
            throw new \InvalidArgumentException(sprintf(
                '%s can only validate %s or %s objects; %s given.',
                self::class,
                Page::class,
                CreateAction::class,
                is_object($page) ? get_class($page) : gettype($page)
            ));
        }
        if ($actualPage = $this->pageLoader->retrieveByPath(
            $page instanceof CreateAction
                ? $page->getFullPath()
                : $page->getPath()
        )) {
            $this->context
                ->buildViolation($constraint->message)
                    ->atPath('path')
                    ->setParameter('{{ name }}', $actualPage->getName())
                    ->setParameter('{{ path }}', $actualPage->getPath())
                    ->setParameter('{{ parent }}', $actualPage->getParent()->getName())
                ->addViolation()
            ;
        }
    }
}

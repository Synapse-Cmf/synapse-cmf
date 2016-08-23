<?php

namespace Synapse\Cmf\Framework\Theme\Template\Action;

use Synapse\Cmf\Framework\Theme\Template\Entity\Template;
use Synapse\Cmf\Framework\Theme\Template\Model\TemplateInterface;
use Majora\Framework\Domain\Action\AbstractAction as MajoraAbstractAction;

/**
 * Base class for Template Actions.
 *
 * @property $template
 */
abstract class AbstractAction extends MajoraAbstractAction
{
    /**
     * @var TemplateInterface
     */
    protected $template;

    /**
     * Initialisation function.
     *
     * @param TemplateInterface $template
     */
    public function init(TemplateInterface $template = null)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * Return related Template if defined.
     *
     * @return TemplateInterface|null $template
     */
    public function getTemplate()
    {
        return $this->template;
    }
}

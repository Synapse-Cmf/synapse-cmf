<?php

namespace Synapse\Cmf\Bundle\Form\Mapper;

use Majora\Framework\Domain\Action\ActionCollection;
use Majora\Framework\Domain\Action\ActionInterface;

/**
 * Template action collection class, used to simplify template form API.
 */
class TemplateActionCollection extends ActionCollection
{
    /**
     * @var array
     */
    protected $templateMap;

    /**
     * Construct.
     *
     * @param array $templateMap
     */
    public function __construct(array $templateMap)
    {
        $this->templateMap = $templateMap;
    }

    /**
     * @see ActionInterface::resolve()
     */
    public function resolve()
    {
        foreach ($this->templateMap as $templateTypeName => $templates) {
            if (empty($templates)) {
                continue;
            }
            foreach ($templates as $mode => $template) {
                if (empty($template)) {
                    continue;
                }
                if ($template instanceof ActionInterface) {
                    $template->resolve();
                    $template = $template->getTemplate();
                }
                $this->set(
                    sprintf('%s_%s', $templateTypeName, $mode),
                    $template
                );
            }
        }

        return $this;
    }
}

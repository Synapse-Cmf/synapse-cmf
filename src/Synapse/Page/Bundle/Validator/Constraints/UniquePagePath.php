<?php

namespace Synapse\Page\Bundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Unique Path constraint for pages definition.
 */
class UniquePagePath extends Constraint
{
    public $message = 'A page named "{{ name }}", child of page "{{ parent }}", already exists at path "/{{ path }}".';

    /**
     * {@inherit_doc}
     */
    public function validatedBy()
    {
        return self::class.'Validator';
    }
}

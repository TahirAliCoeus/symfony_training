<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

class ContainsAlphanumeric extends  Constraint
{
    public $message = 'The string "{{ string }}" contains invalid characters';
    public $mode = 'strict';
}
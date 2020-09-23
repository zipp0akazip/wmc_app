<?php

namespace App\Exceptions\PermissionsControl;

use Throwable;

class ProcedureHaveNoTrait extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message = 'Procedure(' . $message . ') have no App\Traits\ProcedurePermissionControl trait.';

        parent::__construct($message, $code, $previous);
    }
}
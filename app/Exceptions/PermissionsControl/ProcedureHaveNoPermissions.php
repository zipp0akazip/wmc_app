<?php

namespace App\Exceptions\PermissionsControl;

class ProcedureHaveNoPermissions extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message = 'Procedure(' . $message . ') have no $permissions variable.';

        parent::__construct($message, $code, $previous);
    }
}
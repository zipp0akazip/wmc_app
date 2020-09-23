<?php


namespace App\Exceptions\PermissionsControl;


class ProcedurePermissionsEmpty extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        $message = 'Procedure(' . $message . ') permissions are empty.';

        parent::__construct($message, $code, $previous);
    }
}
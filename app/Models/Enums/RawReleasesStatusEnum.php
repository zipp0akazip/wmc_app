<?php

namespace App\Models\Enums;

class RawReleasesStatusEnum extends BaseEnum
{
    const NEW = 'new';
    const HANDLED = 'handled';
    const ERROR = 'error';
}
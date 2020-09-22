<?php

declare(strict_types=1);

namespace App\Http\Procedures;

use App\Repositories\RawReleasesRepository;
use Sajya\Server\Procedure;

class UnapprovedStylesProcedure extends Procedure
{
    /**
     * The name of the procedure that will be
     * displayed and taken into account in the search
     *
     * @var string
     */
    public static string $name = 'unapproved-styles';

    protected RawReleasesRepository $rawReleasesRepository;

    public function __construct(RawReleasesRepository $rawReleasesRepository)
    {
        $this->rawReleasesRepository = $rawReleasesRepository;
    }

    public function list(): array
    {
        return $this->rawReleasesRepository->getUnapprovedStyles();
    }
}

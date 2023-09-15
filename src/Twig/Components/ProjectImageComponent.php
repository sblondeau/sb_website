<?php

namespace App\Twig\Components;

use App\Entity\Project;
use App\Entity\ProjectImage;
use App\Repository\ProjectImageRepository;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;

#[AsLiveComponent()]
final class ProjectImageComponent
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public ?Project $project = null;

    #[LiveProp(writable: true)]
    public ?ProjectImage $actualImage = null;

    public function __construct()
    {
    }


    #[LiveAction()]
    public function zoom(#[LiveArg()] ProjectImage $projectImage): void
    {
        $this->actualImage = $projectImage;
    }
}

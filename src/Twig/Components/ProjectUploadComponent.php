<?php

namespace App\Twig\Components;

use App\Entity\Project;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use App\Entity\ProjectImage;
use Symfony\UX\LiveComponent\Attribute\LiveArg;

#[AsLiveComponent('ProjectUploadComponent')]
class ProjectUploadComponent extends AbstractController
{
    use DefaultActionTrait;

    public function __construct(private ValidatorInterface $validator, private EntityManagerInterface $entityManager)
    {
    }

    // #[LiveProp]
    // public ?string $singleUploadFilename = null;

    #[LiveProp]
    public array $uploadErrors = [];

    #[LiveProp(writable: true)]
    public ?Project $project = null;

    #[LiveProp(writable: true)]
    public array $multipleUploadFilenames = [];

    #[LiveAction]
    public function uploadFiles(Request $request): void
    {
        $multiple = $request->files->all('multiple');
        foreach ($multiple as $file) {
            if ($file instanceof UploadedFile) {
                $this->validateSingleFile($file);
                $filename = $this->processFileUpload($file);
                $this->multipleUploadFilenames[] = ['filename' => $filename];
            }
        }
    }

    private function processFileUpload(UploadedFile $file): string
    {
        $fileName = uniqid() . $file->getClientOriginalName();

        $file->move('uploads', $fileName);

        $projectImage = new ProjectImage();
        $projectImage->setName($fileName);
        $projectImage->setProject($this->project);

        $this->entityManager->persist($projectImage);
        $this->entityManager->flush();

        return $file->getClientOriginalName();
    }

    private function validateSingleFile(UploadedFile $singleFileUpload): void
    {
        $errors = $this->validator->validate($singleFileUpload, [
            new Assert\File([
                'maxSize' => '1M',
            ]),
        ]);

        if (0 === \count($errors)) {
            return;
        }

        $this->uploadErrors[] = $errors->get(0)->getMessage();

        // causes the component to re-render
        throw new UnprocessableEntityHttpException('Validation failed');
    }

    #[LiveAction()]
    public function deleteFile(#[LiveArg()] ProjectImage $projectImage)
    {
        unlink(__DIR__ . '/../../../public/uploads/' . $projectImage->getName());
        $this->entityManager->remove($projectImage);
        $this->entityManager->flush();
    }
}

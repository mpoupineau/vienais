<?php
/**
 * Created by PhpStorm.
 * User: mpoupineau
 * Date: 20/01/20
 * Time: 18:46
 */

namespace App\Manager\Photo;


use App\Entity\Photo;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PhotoManager
{
    /** @var EntityManagerInterface $entityManager */
    private $entityManager;

    /** @var ParameterBagInterface */
    private $parameterBag;

    public function __construct(EntityManagerInterface $entityManager, ParameterBagInterface $parameterBag)
    {
        $this->entityManager = $entityManager;
        $this->parameterBag = $parameterBag;
    }


    public function add(Photo $photo)
    {
        /** @var UploadedFile $file */
        $file = $photo->getImageFile();

        if ($file) {
            $fileName = uniqid().'_photo.'.$file->guessExtension();
            try {
                $file->move(
                    $this->parameterBag->get('photo_location'),
                    $fileName
                );
                $photo->setImagePath($fileName);

            } catch (FileException $e) {
                throw new FileException("Erreur lors de l'enregistrement de l'image");
            }
        }

        $this->entityManager->persist($photo);
        $this->entityManager->flush();
    }

    public function delete(Photo $photo)
    {
        $this->entityManager->remove($photo);
        $this->entityManager->flush();
    }
}
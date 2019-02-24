<?php
namespace App\Product;
use App\Entity\Cuvee;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Created by PhpStorm.
 * User: mpoupineau
 * Date: 24/02/19
 * Time: 01:03
 */

class CuveeManager
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


    public function add(Cuvee $cuvee)
    {
        /** @var UploadedFile $file */
        $file = $cuvee->getImageFile();

        if ($file) {
            $fileName = uniqid().'_cuvee.'.$file->guessExtension();
            try {
                $file->move(
                    $this->parameterBag->get('image_cuvee_location'),
                    $fileName
                );
                $cuvee->setImagePath($fileName);

            } catch (FileException $e) {
                throw new FileException("Erreur lors de l'enregistrement de l'image");
            }
        }

        $this->entityManager->persist($cuvee);
        $this->entityManager->flush();
    }

    public function delete(Cuvee $cuvee)
    {
        $this->entityManager->remove($cuvee);
        $this->entityManager->flush();
    }
}
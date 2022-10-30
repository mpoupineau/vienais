<?php
namespace App\Manager\Product;
use App\Entity\Prize;
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

class PrizeManager
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


    public function add(Prize $prize)
    {
        /** @var UploadedFile $file */
        $file = $prize->getImageFile();

        if ($file) {
            $fileName = uniqid().'_prize.'.$file->guessExtension();
            try {
                $file->move(
                    $this->parameterBag->get('image_prize_location'),
                    $fileName
                );
                $prize->setImagePath($fileName);

            } catch (FileException $e) {
                throw new FileException("Erreur lors de l'enregistrement de l'image");
            }
        }

        $this->entityManager->persist($prize);
        $this->entityManager->flush();
    }

    public function delete(Prize $prize)
    {
        $this->entityManager->remove($prize);
        $this->entityManager->flush();
    }
}
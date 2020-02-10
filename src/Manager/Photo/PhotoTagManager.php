<?php
namespace App\Manager\Photo;

use App\Entity\PhotoTag;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * Created by PhpStorm.
 * User: mpoupineau
 * Date: 24/02/19
 * Time: 01:03
 */

class PhotoTagManager
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


    public function add(PhotoTag $wineType)
    {
        $this->entityManager->persist($wineType);
        $this->entityManager->flush();
    }

    public function delete(PhotoTag $wineType)
    {
        $this->entityManager->remove($wineType);
        $this->entityManager->flush();
    }
}
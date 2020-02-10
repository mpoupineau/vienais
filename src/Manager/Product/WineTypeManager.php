<?php
namespace App\Manager\Product;
use App\Entity\WineType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * Created by PhpStorm.
 * User: mpoupineau
 * Date: 24/02/19
 * Time: 01:03
 */

class WineTypeManager
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


    public function add(WineType $wineType)
    {
        $this->entityManager->persist($wineType);
        $this->entityManager->flush();
    }

    public function delete(WineType $wineType)
    {
        $this->entityManager->remove($wineType);
        $this->entityManager->flush();
    }
}
<?php
namespace App\Manager\Product;
use App\Entity\Bottle;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * Created by PhpStorm.
 * User: mpoupineau
 * Date: 24/02/19
 * Time: 01:03
 */

class BottleManager
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


    public function add(Bottle $bottle)
    {
        $this->entityManager->persist($bottle);
        $this->entityManager->flush();
    }

    public function delete(Bottle $bottle)
    {
        $this->entityManager->remove($bottle);
        $this->entityManager->flush();
    }
}
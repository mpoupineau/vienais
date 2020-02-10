<?php
namespace App\Manager\Product;
use App\Entity\Capacity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * Created by PhpStorm.
 * User: mpoupineau
 * Date: 24/02/19
 * Time: 01:03
 */

class CapacityManager
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


    public function add(Capacity $capacity)
    {
        $this->entityManager->persist($capacity);
        $this->entityManager->flush();
    }

    public function delete(Capacity $capacity)
    {
        $this->entityManager->remove($capacity);
        $this->entityManager->flush();
    }
}
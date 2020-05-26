<?php
namespace App\Manager\Product;
use App\Entity\Vintage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * Created by PhpStorm.
 * User: mpoupineau
 * Date: 24/02/19
 * Time: 01:03
 */

class VintageManager
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


    public function add(Vintage $vintage)
    {
        $this->entityManager->persist($vintage);
        $this->entityManager->flush();
    }

    public function delete(Vintage $vintage)
    {
        $this->entityManager->remove($vintage);
        $this->entityManager->flush();
    }
}
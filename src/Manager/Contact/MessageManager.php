<?php
namespace App\Manager\Contact;
use App\Entity\Message;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;


class MessageManager
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


    public function add(Message $message)
    {
        $this->entityManager->persist($message);
        $this->entityManager->flush();
    }

    public function delete(Message $message)
    {
        $this->entityManager->remove($message);
        $this->entityManager->flush();
    }
}
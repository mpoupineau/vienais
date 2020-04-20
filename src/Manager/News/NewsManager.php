<?php


namespace App\Manager\News;


use App\Entity\News;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class NewsManager
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


    public function add(News $news)
    {
        /** @var UploadedFile $file */
        $file = $news->getImageFile();

        if ($file) {
            $fileName = uniqid().'_news.'.$file->guessExtension();
            try {
                $file->move(
                    $this->parameterBag->get('image_news_location'),
                    $fileName
                );
                $news->setImagePath($fileName);

            } catch (FileException $e) {
                throw new FileException("Erreur lors de l'enregistrement de l'image");
            }
        }

        $this->entityManager->persist($news);
        $this->entityManager->flush();
    }

    public function delete(News $news)
    {
        $this->entityManager->remove($news);
        $this->entityManager->flush();
    }
}
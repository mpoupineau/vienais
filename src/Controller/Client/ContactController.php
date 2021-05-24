<?php


namespace App\Controller\Client;


use App\Entity\Message;
use App\Form\Client\Contact\MessageType;
use App\Manager\Contact\MessageManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

/** @Route("/contact", name="client_contact") */
class ContactController extends AbstractController
{
    /**
     * @Route("", name="")
     */
    public function contact(Request $request, MessageManager $messageManager)
    {
        $form = $this->createForm(MessageType::class, new Message());
        $form->handleRequest($request);
        $formResponse = "";

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $messageManager->add($form->getData());
                $formResponse = "Merci pour votre message, nous vous répondrons dès que possible";
            } else {
                $formResponse = "Une erreur est apparue dans l'envoi du message, vous pouvez nous contacter en envoyant directement un mail à contact@domaine-des-vienais.com.";
            }
        }

        return $this->render('client/page/contact.html.twig',
            [
                'form' => $form->createView(),
                'formResponse' => $formResponse
            ]);
    }
}
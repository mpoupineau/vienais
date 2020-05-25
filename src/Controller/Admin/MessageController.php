<?php

namespace App\Controller\Admin;

use App\Entity\Message;
use App\Manager\Contact\MessageManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

/** @Route("/admin/message", name="admin_message") */
class MessageController extends AbstractController
{

    /**
     * @Route("", name="")
     */
    public function message()
    {

        return $this->render('admin/page/message.html.twig',
            [
                'messages' => $this->getDoctrine()->getRepository(Message::class)->findBy(
                    [
                        'archived' => false
                    ],
                    [
                        'date' => "DESC"
                    ]
                )
            ]);
    }

    /**
     * @Route("/{messageId}", name="_details")
     */
    public function messageDetails(MessageManager $messageManager, $messageId)
    {
        /**
         * @var Message $message
         */
        $message = $this->getDoctrine()->getRepository(Message::class)->find($messageId);

        if ($message->isNew()) {
            $message->setNew(false);
            $messageManager->add($message);
        }
        return $this->render('admin/page/message.html.twig',
            [
                'messages' => $this->getDoctrine()->getRepository(Message::class)->findBy(
                    [
                        'archived' => false
                    ],
                    [
                        'date' => "DESC"
                    ]
                ),
                'messageDetails' => $this->getDoctrine()->getRepository(Message::class)->find($messageId)
            ]);
    }

    /**
     * @Route("/{messageId}/archive", name="_archive")
     */
    public function messageArchive(MessageManager $messageManager, $messageId)
    {
        /** @var Message $message */
        $message = $this->getDoctrine()->getRepository(Message::class)->find($messageId);

        $message->setArchived(true);
        $messageManager->add($message);

        $session = new Session();
        $session->getFlashBag()->add('success', "Le message a bien été archivé");

        return $this->redirectToRoute('admin_message');
    }

    /**
     * @Route("/{messageId}/delete", name="_delete")
     */
    public function messageDelete(MessageManager $messageManager, $messageId)
    {
        /** @var Message $message */
        $message = $this->getDoctrine()->getRepository(Message::class)->find($messageId);
        $messageManager->delete($message);

        $session = new Session();
        $session->getFlashBag()->add('success', "Le message a bien été supprimé");

        return $this->redirectToRoute('admin_message');
    }
}
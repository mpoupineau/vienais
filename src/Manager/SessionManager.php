<?php

namespace App\Manager;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SessionManager
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function getBottles()
    {
        return $this->session->get('bottles', []);
    }

    public function updateBottles($bottles)
    {
        $bottlesOrdered = $this->session->get('bottles', []);

        foreach ($bottles as $key => $value){
            if ("" !== $value) {
                $bottlesOrdered[$key] = $value;
            }
        }
        $this->session->set('bottles', $bottlesOrdered);
    }

    public function removeBottles()
    {
        $this->session->remove('bottles');
    }

    public function getPromoCode()
    {
        return $this->session->get('promoCode', "");
    }

    public function updatePromoCode($codeId)
    {
        $this->session->set('promoCode', $codeId);
    }

    public function removePromoCode()
    {
        $this->session->remove('promoCode');
    }
}
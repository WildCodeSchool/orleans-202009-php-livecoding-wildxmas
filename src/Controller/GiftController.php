<?php

namespace App\Controller;

use App\Repository\GiftRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GiftController extends AbstractController
{
    /**
     * @Route("/gift", name="gift_index")
     */
    public function index(GiftRepository $giftRepository): Response
    {
        $gifts = $giftRepository->findAll();
        return $this->render('gift/index.html.twig', [
           'gifts' => $gifts,
        ]);
    }
}

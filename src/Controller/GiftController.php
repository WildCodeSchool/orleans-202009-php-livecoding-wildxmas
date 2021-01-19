<?php

namespace App\Controller;

use App\Entity\GiftSearch;
use App\Entity\Universe;
use App\Form\GiftSearchType;
use App\Repository\GiftRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GiftController extends AbstractController
{
    /**
     * @Route("/gift/{name}", name="gift_index")
     */
    public function index(GiftRepository $giftRepository, Request $request, Universe $universe): Response
    {
        $giftSearch = new GiftSearch();
        $form = $this->createForm(GiftSearchType::class, $giftSearch, ['universe' => $universe]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $gifts = $giftRepository->findGift($giftSearch);
        }

        return $this->render('gift/index.html.twig', [
            'gifts' => $gifts ?? $giftRepository->findAll(),
            'form'  => $form->createView(),
        ]);
    }
}

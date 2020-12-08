<?php

namespace App\Controller;

use App\Entity\Gift;
use App\Form\GiftType;
use App\Repository\GiftRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/gift", name="admin_gift_")
 */
class AdminGiftController extends AbstractController
{
    /**
     * @Route("/index", name="index")
     */
    public function index(GiftRepository $giftRepository): Response
    {
        $gifts = $giftRepository->findAll();
        return $this->render('admin_gift/index.html.twig', [
            'gifts' => $gifts,
        ]);
    }
    /**
     * @Route("/new", name="new")
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $gift = new Gift();
        $form = $this->createForm(GiftType::class, $gift);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($gift);
            $entityManager->flush();

            return $this->redirectToRoute('admin_gift_index');
        }

        return $this->render('admin_gift/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="edit")
     */
    public function edit(Gift $gift, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(GiftType::class, $gift);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_gift_index');
        }

        return $this->render('admin_gift/edit.html.twig', [
            'form' => $form->createView(),
            'gift' => $gift,
        ]);
    }
}

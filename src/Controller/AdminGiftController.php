<?php

namespace App\Controller;

use App\Entity\Gift;
use App\Form\GiftType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminGiftController extends AbstractController
{
    /**
     * @Route("/admin/gift/new", name="admin_new")
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $gift = new Gift();
        $form = $this->createForm(GiftType::class, $gift);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($gift);
            $entityManager->flush();

            return $this->redirectToRoute('admin_new');
        }

        return $this->render('admin_gift/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

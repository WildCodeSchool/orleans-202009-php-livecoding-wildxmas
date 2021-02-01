<?php

namespace App\Controller;

use App\Entity\GiftList;
use App\Repository\GiftListRepository;
use App\Services\GiftListMailer;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class AdminListController extends AbstractController
{
    /**
     * @Route("/admin/list", name="admin_list")
     */
    public function index(GiftListRepository $giftListRepository): Response
    {
        return $this->render('admin_list/index.html.twig', [
            'lists' => $giftListRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/show/{id}", name="admin_list_show")
     */
    public function show(GiftList $giftList): Response
    {
        return $this->render('admin_list/show.html.twig', [
            'list' => $giftList,
        ]);
    }

    /**
     * @Route("/list/pdf/{id}", name="list_pdf")
     */
    public function sendPDF(GiftList $giftList, GiftListMailer $giftListMailer): Response
    {
        $giftListMailer->send($giftList);
        $this->addFlash('success', 'La liste a été envoyée');

        return $this->redirectToRoute('admin_list');
    }
}

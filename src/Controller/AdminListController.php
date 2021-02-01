<?php

namespace App\Controller;

use App\Entity\GiftList;
use App\Repository\GiftListRepository;
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
    public function sendPDF(GiftList $giftList, MailerInterface $mailer): Response
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('admin_list/pdf.html.twig', [
            'list' => $giftList,
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // Render the HTML as PDF
        $dompdf->render();

        // Store PDF Binary Data
        $output = $dompdf->output();


        $email = (new Email())
            ->from('hello@example.com')
            ->to('you@example.com')
            ->subject('List PDF')
            ->text('Ma liste en PDF!')
            ->attach($output);

        $mailer->send($email);

        $this->addFlash('success', 'La liste a été envoyée');

        return $this->redirectToRoute('admin_list');
        // Output the generated PDF to Browser (force download)
//        $dompdf->stream("list.pdf", [
//            "Attachment" => true,
//        ]);
    }
}

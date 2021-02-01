<?php

namespace App\Services;

use App\Entity\Gift;
use App\Entity\GiftList;
use App\Repository\GiftListRepository;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class GiftListMailer
{
    /**
     * @var MailerInterface
     */
    private MailerInterface $mailer;
    private Environment $twig;
    private GiftListRepository $giftListRepository;

    public function __construct(MailerInterface $mailer, Environment $twig, GiftListRepository $giftListRepository)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->giftListRepository = $giftListRepository;
    }

    public function sendAll(): void
    {
        $giftLists = $this->giftListRepository->findAll();
        foreach ($giftLists as $giftList) {
            $this->send($giftList);
        }
    }

    public function send(GiftList $giftList): void
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        // Retrieve the HTML generated in our twig file
        $html = $this->twig->render('admin_list/pdf.html.twig', [
            'list' => $giftList,
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // Render the HTML as PDF
        $dompdf->render();

        // Store PDF Binary Data
        /** @var string $output */
        $output = $dompdf->output();

        /** var User $user */
        $user = $giftList->getUser();

        $email = (new Email())
            ->from('hello@example.com')
            ->to('you@example.com')
            ->subject('List PDF')
            ->text('La liste de ' .  $user->getEmail() . ' en PDF!')
            ->attach($output);

        $this->mailer->send($email);
    }
}

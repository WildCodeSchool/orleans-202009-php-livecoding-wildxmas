<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(MailerInterface $mailer): Response
    {
//        $email = (new Email())
//            ->from('test@test.com')
//            ->to('sylvain.blondeau@wildcodeschool.com')
//            //->cc('cc@example.com')
//            //->bcc('bcc@example.com')
//            //->replyTo('fabien@example.com')
//            //->priority(Email::PRIORITY_HIGH)
//            ->subject('Test mail!')
//            ->text('Sending emails is fun again!');
//
//        $mailer->send($email);

        return $this->render('home/index.html.twig');
    }
}

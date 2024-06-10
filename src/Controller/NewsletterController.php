<?php

namespace App\Controller;

use App\Entity\NewsletterEmail;
use App\Form\NewsletterType;
use App\Newsletter\EmailNotification;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

class NewsletterController extends AbstractController
{


    #[Route('/newsletter/subscribe', name: 'newsletter_subscribe')]
    public function subscribe(
        Request $request,
        EntityManagerInterface $em,
        EmailNotification $emailNotification,
        
    ): Response {
        $newsletterEmail = new NewsletterEmail();
        $form = $this->createForm(NewsletterType::class, $newsletterEmail);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($newsletterEmail);
            $em->flush();
            $emailNotification->sendConfirmationEmail($newsletterEmail);

            // $email = (new Email())
            //     ->from('moi@hotmail.com')
            //     ->to($newsletterEmail->getEmail())      +    mailerInterface 
            //     ->subject('inscription')
            //     ->text('votre emil'. $newsletterEmail->getEmail(). ' a bien ete enregistrer');
            // $mailer->send($email);

            $this->addFlash('success', 'subscribe saved');

            return $this->redirectToRoute('app_index');
        }

        return $this->render('newsletter/subscribe.html.twig', [
            'newsletterform' => $form
        ]);
    }

}
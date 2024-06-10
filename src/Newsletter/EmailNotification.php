<?php

namespace App\Newsletter;

use App\Entity\NewsletterEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;


class EmailNotification
{
  public function __construct(private MailerInterface $mailer, private string $adminEmail )
  {

  }

  public function sendConfirmationEmail(NewsletterEmail $newEmail): void
  {
    $email = (new Email())
     ->from($this->adminEmail)
      ->to($newEmail->getEmail())
      ->subject("inscription à la newsletter")
      ->text("votre email" . $newEmail->getEmail() . "a bien été enregisté, merci");

    $this->mailer->send($email);


  }
}


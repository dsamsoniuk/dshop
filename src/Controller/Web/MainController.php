<?php

namespace App\Controller\Web;

use App\Entity\Notification;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Envelope;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\RawMessage;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(Security $security, EntityManagerInterface $em): Response
    {
        // /** @var User $user */
        // $user = $security->getUser();

        // $notific = new Notification();
        // $notific->setTitle('Order created.');
        // $notific->setMessage('Order has been sended to the shop.');
        // // $notific->setUser($user);
        // $user->addNotification($notific);
        // $em->persist($user);
        // $em->flush();

        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
}

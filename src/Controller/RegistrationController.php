<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register', methods: ['GET','POST'])]
    public function register(
        Request $request,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $em,
        CsrfTokenManagerInterface $csrfTokenManager
        ): Response {
    $csrfToken = $csrfTokenManager->getToken('register_form')->getValue();

    if ($request->isMethod('POST')) {
        $submittedToken = $request->request->get('_csrf_token');

        if (!$csrfTokenManager->isTokenValid(new CsrfToken('register_form', $submittedToken))) {
            throw $this->createAccessDeniedException('Invalid CSRF token.');
        }

        $user = new User();
        $user->setEmail($request->request->get('email'));
        $user->setPassword(
            $passwordHasher->hashPassword($user, $request->request->get('password'))
        );

        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('app_login');
    }

    return $this->render('registration/register.html.twig', [
        'csrf_token' => $csrfToken
    ]);
}
}
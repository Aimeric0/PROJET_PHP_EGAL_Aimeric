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
        
        
        if ($request->isMethod('POST')) {

            $submittedToken = $request->request->get('_csrf_token');

            if (!$this->isCsrfTokenValid('register_form', $submittedToken)) {
                $this->addFlash('error', 'Token de sécurité invalide.');
                return $this->redirectToRoute('app_register');
            }

            $email = $request->request->get('email');
            $plainPassword = $request->request->get('password');

            if (empty($email) || empty($plainPassword)) {
                $this->addFlash('error', 'Veuillez remplir tous les champs.');
                return $this->redirectToRoute('app_register');
            }

            $user = new User();
            $user->setEmail($email);
            $user->setRoles(['ROLE_USER']); 
            
            $user->setPassword(
                $passwordHasher->hashPassword($user, $plainPassword)
            );

            try {
                $em->persist($user);
                $em->flush();
                $this->addFlash('success', 'Compte créé ! Connectez-vous.');
                return $this->redirectToRoute('app_login');
            } catch (\Exception $e) {
                $this->addFlash('error', 'Erreur lors de l\'inscription (Email déjà pris ?)');
            }
        }

        $csrfToken = $csrfTokenManager->getToken('register_form')->getValue();

        return $this->render('registration/register.html.twig', [
            'csrf_token' => $csrfToken
        ]);
    }

}
<?php

namespace App\Controller;

use App\Entity\Build;
use App\Form\BuildType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BuildController extends AbstractController
{
#[Route('/build/new', name: 'build_new')]
public function new(Request $request, EntityManagerInterface $em): Response
{
    $build = new Build();
    $form = $this->createForm(BuildType::class, $build);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $em->persist($build);
        $em->flush();

        $this->addFlash('success', 'Build créé avec succès !');

        return $this->redirectToRoute('build_new');
    }

    return $this->render('build_controller_php/index.html.twig', [
        'form' => $form->createView(),
    ]);
}
}
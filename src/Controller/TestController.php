<?php

namespace App\Controller;

use App\Entity\Child;
use App\Form\ChildType;
use App\Repository\ChildRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class TestController extends AbstractController
{
    #[Route('/', name: 'child_edit')]
    public function test(Request $request, ChildRepository $childRepository, EntityManagerInterface $entityManager): Response
    {
        $child = $childRepository->find(1);
        $form = $this->createForm(ChildType::class, $child);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($child);
            $entityManager->flush();

            return new Response('SAVED');
        }

        return $this->render('test.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
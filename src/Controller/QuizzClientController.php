<?php

namespace App\Controller;

use App\Entity\Quizz;
use App\Form\Quizz1Type;
use App\Repository\QuizzRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/quizz/client')]
class QuizzClientController extends AbstractController
{
    #[Route('/', name: 'app_quizz_client_index', methods: ['GET'])]
    public function index(QuizzRepository $quizzRepository): Response
    {
        return $this->render('quizz_client/index.html.twig', [
            'quizzs' => $quizzRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_quizz_client_new', methods: ['GET', 'POST'])]
    public function new(Request $request, QuizzRepository $quizzRepository): Response
    {
        $quizz = new Quizz();
        $form = $this->createForm(Quizz1Type::class, $quizz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $quizzRepository->save($quizz, true);

            return $this->redirectToRoute('app_quizz_client_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('quizz_client/new.html.twig', [
            'quizz' => $quizz,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_quizz_client_show', methods: ['GET'])]
    public function show(Quizz $quizz): Response
    {
        return $this->render('quizz_client/show.html.twig', [
            'quizz' => $quizz,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_quizz_client_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Quizz $quizz, QuizzRepository $quizzRepository): Response
    {
        $form = $this->createForm(Quizz1Type::class, $quizz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $quizzRepository->save($quizz, true);

            return $this->redirectToRoute('app_quizz_client_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('quizz_client/edit.html.twig', [
            'quizz' => $quizz,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_quizz_client_delete', methods: ['POST'])]
    public function delete(Request $request, Quizz $quizz, QuizzRepository $quizzRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$quizz->getId(), $request->request->get('_token'))) {
            $quizzRepository->remove($quizz, true);
        }

        return $this->redirectToRoute('app_quizz_client_index', [], Response::HTTP_SEE_OTHER);
    }
}

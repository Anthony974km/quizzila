<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ResultatRepository;
use App\Repository\ReponseRepository;
use App\Entity\Quizz;
use App\Entity\Resultat;

class DoQuizzController extends AbstractController
{
    #[Route('/do/quizz/{id}', name: 'app_do_quizz')]
    public function index(Quizz $quizz, ResultatRepository $resultatRepository, ReponseRepository $reponseRepository): Response
    {
        $user = $this->getUser();
        if (isset($_POST)){
            $reponseId = array_key_first($_POST);
            if ($reponseId){
            $reponse = $reponseRepository->find($reponseId);
            $resultat = new Resultat();
            $resultat->setReponse($reponse);
            $resultat->setClient($user);
            $resultatRepository->save($resultat, true);
            }
        }
        
        $resultatClient = $resultatRepository->findBy(["client"=>$user]);

        $questions = $quizz->getQuestions();
        $questionClient = [];

        foreach ($resultatClient as $resultat) {
            $reponse= $resultat->getReponse();
            $q = $reponse->getQuestion();
            array_push($questionClient, $q);
        }

        foreach ($questions as $q){
            if (!in_array ($q, $questionClient)){
                return $this->render('do_quizz/show.html.twig', [
                    'question' => $q,
                    'quizz' => $quizz
                ]);

            }

        }

        
        // dump($quizz);
        // dump($questions[0]);
        // dump($questionClient);

 
        return $this->render('do_quizz/index.html.twig', [
            'controller_name' => 'DoQuizzController',
        ]);
    }
}

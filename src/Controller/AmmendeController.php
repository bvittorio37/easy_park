<?php

namespace App\Controller;

use App\Entity\Ammende;
use App\Form\AmmendeType;
use App\Repository\AmmendeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/ammende')]
class AmmendeController extends AbstractController
{
    #[Route('/', name: 'app_ammende_index', methods: ['GET'])]
    public function index(AmmendeRepository $ammendeRepository): Response
    {
        return $this->render('ammende/index.html.twig', [
            'ammendes' => $ammendeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_ammende_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AmmendeRepository $ammendeRepository): Response
    {
        $ammende = new Ammende();
        $form = $this->createForm(AmmendeType::class, $ammende);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $ammende->setDateCreation(date_create(date('Y-m-d H:i:s')));
            $ammendeRepository->add($ammende, true);

            return $this->redirectToRoute('app_ammende_new', [], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('ammende/new.html.twig', [
            'ammende' => $ammende,
            'form' => $form,
        ]);
    }
 
}

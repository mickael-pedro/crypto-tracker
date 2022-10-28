<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Coin;
use App\Form\CoinFormType;
use App\Service\UpdateBalanceService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class CoinController extends AbstractController
{
    #[Route('/add', name: 'add_coin')]
    public function add(Request $request, ManagerRegistry $doctrine, UpdateBalanceService $updateBalance): Response
    {
        $form = $this->createForm(CoinFormType::class)
            ->add('save', SubmitType::class, ['label' => 'Envoyer']);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $entityManager = $doctrine->getManager();
            $coin = $entityManager->getRepository(Coin::class)->findOneBy(array('coinname' => $data['coinname']));

            if (!$coin) {
                throw $this->createNotFoundException(
                    'No coin found for coinname '.$data['coinname']
                );
            }
            
            $coin->setQuantity($coin->getQuantity() + $data['quantity']);
            $entityManager->flush();

            $updateBalance->updateBalance();

            return $this->redirectToRoute('homepage');
        }
        
        return $this->render('coin/coinform.html.twig', [
            'coin_form' => $form->createView(),
            'title' => 'Ajouter une transaction',
        ]);
    }
    
    #[Route('/delete', name: 'delete_coin')]
    public function delete(Request $request, ManagerRegistry $doctrine, UpdateBalanceService $updateBalance): Response
    {
        $form = $this->createForm(CoinFormType::class)
            ->add('save', SubmitType::class, ['label' => 'Envoyer']);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $entityManager = $doctrine->getManager();
            $coin = $entityManager->getRepository(Coin::class)->findOneBy(array('coinname' => $data['coinname']));

            if (!$coin) {
                throw $this->createNotFoundException(
                    'No coin found for coinname '.$data['coinname']
                );
            }
            
            $quantityToRemove = $coin->getQuantity() - $data['quantity'];
            $coin->setQuantity($quantityToRemove < 0 ? 0 : $quantityToRemove );
            $entityManager->flush();

            $updateBalance->updateBalance();

            return $this->redirectToRoute('homepage');
        }
        
        return $this->render('coin/coinform.html.twig', [
            'coin_form' => $form->createView(),
            'title' => 'Supprimer un montant',
        ]);
    }
}

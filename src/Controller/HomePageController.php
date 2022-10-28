<?php

namespace App\Controller;

use App\Entity\BalanceHistory;
use App\Entity\Coin;
use App\Service\UpdateBalanceService;
use Doctrine\Persistence\ManagerRegistry;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomePageController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(ManagerRegistry $doctrine, UpdateBalanceService $updateBalance): Response
    {
        $entityManager = $doctrine->getManager();
        
        $updateBalance = $updateBalance;
        $balance = $this->getDailyBalance($entityManager, $updateBalance);

        $coinData = $entityManager->getRepository(Coin::class)->findAll();
        foreach($coinData as $data){
            $changeLast24h[$data->getCoinname()] = $data->getPercentChange24h();
        }

        return $this->render('home_page/index.html.twig', [
            'balance' => $balance->getTotalBalance(),
            'changeLast24h' => $changeLast24h,
        ]);
    }

    public function getDailyBalance($entityManager, UpdateBalanceService $updateBalance)
    {
        $balance = $entityManager->getRepository(BalanceHistory::class)->findOneBy(array('Date' => new DateTime('now')));
        if ($balance)
        {
            return $balance;
        } else {
            return $updateBalance->updateBalance();
        }
    }
}

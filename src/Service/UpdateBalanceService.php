<?php

namespace App\Service;

use App\Entity\BalanceHistory;
use App\Entity\Coin;
use App\Service\CallCoinApiService;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;

class UpdateBalanceService 
{
    private $entityManager;
    private $btc;
    private $eth;
    private $xrp;
    private $balance;
    private $coinApi;

    public function __construct(ManagerRegistry $doctrine, CallCoinApiService $coinApi)
    {
        $this->entityManager = $doctrine->getManager();
        $this->btc = $this->entityManager->getRepository(Coin::class)->findOneBy(array('coinname' => 'btc'));
        $this->eth = $this->entityManager->getRepository(Coin::class)->findOneBy(array('coinname' => 'eth'));
        $this->xrp = $this->entityManager->getRepository(Coin::class)->findOneBy(array('coinname' => 'xrp'));
        $this->balance = $this->entityManager->getRepository(BalanceHistory::class)->findOneBy(array('Date' => new DateTime('now')));
        $this->coinApi = $coinApi;
    }

    public function updateBalance() : BalanceHistory
    {
        if($this->balance){
            $this->balance->setBtcBalance($this->btc->getEurPrice() * $this->btc->getQuantity());
            $this->balance->setEthBalance($this->eth->getEurPrice() * $this->eth->getQuantity());
            $this->balance->setXrpBalance($this->xrp->getEurPrice() * $this->xrp->getQuantity());
            $this->balance->setTotalBalance($this->balance->getBtcBalance() + $this->balance->getEthBalance() + $this->balance->getXrpBalance());    

            $this->entityManager->flush();

            return $this->balance;
        } else {
            $data = $this->coinApi->getCoinPriceData();

            $this->btc->setEurPrice($data['data']['1']['quote']['EUR']['price']);
            $this->eth->setEurPrice($data['data']['1027']['quote']['EUR']['price']);
            $this->xrp->setEurPrice($data['data']['52']['quote']['EUR']['price']);
            $this->btc->setPercentChange24h($data['data']['1']['quote']['EUR']['percent_change_24h']);
            $this->eth->setPercentChange24h($data['data']['1027']['quote']['EUR']['percent_change_24h']);
            $this->xrp->setPercentChange24h($data['data']['52']['quote']['EUR']['percent_change_24h']);


            $newBalance = new BalanceHistory();
            $newBalance->setBtcBalance($this->btc->getEurPrice() * $this->btc->getQuantity());
            $newBalance->setEthBalance($this->eth->getEurPrice() * $this->eth->getQuantity());
            $newBalance->setXrpBalance($this->xrp->getEurPrice() * $this->xrp->getQuantity());
            $newBalance->setTotalBalance($newBalance->getBtcBalance() + $newBalance->getEthBalance() + $newBalance->getXrpBalance());    
            $newBalance->setDate(new DateTime('now'));

            $this->entityManager->persist($newBalance);
            $this->entityManager->flush();

            return $newBalance;
        }
    }
}
<?php

namespace App\DataFixtures;

use App\Entity\BalanceHistory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Coin;
use DateTime;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $btc = new Coin();
        $btc->setCoinname("btc");
        $btc->setQuantity(0.0072);
        $btc->setEurPrice(19464);
        $btc->setPercentChange24h(-0.2);
        $manager->persist($btc);

        $eth = new Coin();
        $eth->setCoinname("eth");
        $eth->setQuantity(0.05);
        $eth->setEurPrice(1321);
        $eth->setPercentChange24h(0.31);
        $manager->persist($eth);

        $xrp = new Coin();
        $xrp->setCoinname("xrp");
        $xrp->setQuantity(0.14);
        $xrp->setEurPrice(0.47);
        $xrp->setPercentChange24h(-0.37);
        $manager->persist($xrp);

        $balance = new BalanceHistory();
        $balance->setBtcBalance($btc->getEurPrice() * $btc->getQuantity());
        $balance->setEthBalance($eth->getEurPrice() * $eth->getQuantity());
        $balance->setXrpBalance($xrp->getEurPrice() * $xrp->getQuantity());
        $balance->setTotalBalance($balance->getBtcBalance() + $balance->getEthBalance() + $balance->getXrpBalance());
        $balance->setDate(new DateTime('now'));
        $manager->persist($balance);

        $manager->flush();
    }
}

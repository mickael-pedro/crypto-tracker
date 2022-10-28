<?php

namespace App\Controller;

use App\Entity\BalanceHistory;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class GraphPageController extends AbstractController
{
    #[Route('/graph', name: 'graph_page')]
    public function index(ManagerRegistry $doctrine, ChartBuilderInterface $chartBuilder): Response
    {
        $entityManager = $doctrine->getManager();
        $balanceHistoryData = $entityManager->getRepository(BalanceHistory::class)->findAll();

        $chart = $chartBuilder->createChart(Chart::TYPE_LINE);

        foreach($balanceHistoryData as $data){
            $dates[] = $data->getDate()->format('d-m-Y');
            $balances[] = $data->getTotalBalance();
        }

        $chart->setData([
            'labels' => $dates,
            'datasets' => [
                [
                    'label' => '€',
                    'backgroundColor' => '#1fc36c',
                    'borderColor' => '#1fc36c',
                    'data' => $balances,
                ],
            ],
        ]);

        $chart->setOptions([
            'plugins' => [
                'legend' => [
                    'display' => false
                ],
            ],
            'scales' => [
                'y' => [
                    'grid' => [
                        'borderColor' => '#dfdfdf',
                        'drawOnChartArea' => false
                    ]
                ],
                'x' => [
                    'grid' => [
                        'borderColor' => '#dfdfdf',
                        'drawOnChartArea' => false
                    ]
                ],
            ]
        ]);

        return $this->render('graph_page/index.html.twig', [
            'chart' => $chart,
            'title' => 'Vos gains'
        ]);
    }
}

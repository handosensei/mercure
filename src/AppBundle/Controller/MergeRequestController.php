<?php

namespace AppBundle\Controller;

use AppBundle\Helper\DateHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MergeRequestController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function setToClosedAction($mergeRequestId, Request $request)
    {
        $mergeRequest = $this->get('app.merge_request.repository')->findOneByApiId($mergeRequestId);

        return $this->render('merge_request/index.html.twig', ['mergeRequest' => $mergeRequest]);
    }

    /**
     * @param string $apiId
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction($apiId, Request $request)
    {
        $mergeRequest = $this->get('app.merge_request.repository')->findOneByApiId($apiId);

        return $this->render('merge_request/index.html.twig', ['mergeRequest' => $mergeRequest]);
    }

    /**
     * Affichage des stats mensuels sur les 12 derniers mois
     * @param Request $request
     * @return Response
     */
    public function dashboardAction(Request $request, $status)
    {
        $stats = [];
        foreach (DateHelper::getLimitEachMonth(12) as $date) {
            $stats[$date->format('Y-m')] = $this->get('app.merge_request.service')->buildReportByMonth($date, $status);
        }

        return $this->render('merge_request/dashboard.html.twig', ['stats' => $stats]);
    }
}

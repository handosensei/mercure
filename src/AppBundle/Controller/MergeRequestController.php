<?php

namespace AppBundle\Controller;

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
     * @param string $apiId
     * @param Request $request
     * @return Response
     */
    public function testAction($apiId, Request $request)
    {
        $mergeRequest = $this->get('app.merge_request.repository')->findOneByApiId($apiId);

        $result = $this->get('app.merge_request.service')->totalChanges($mergeRequest);
dump($result);exit;
        return $this->render('merge_request/index.html.twig', ['mergeRequest' => $mergeRequest]);
    }
}

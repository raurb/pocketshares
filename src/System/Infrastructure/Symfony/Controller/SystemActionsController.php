<?php

declare(strict_types=1);

namespace PocketShares\System\Infrastructure\Symfony\Controller;

use PocketShares\Shared\Infrastructure\Controller\ApiController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/system', name: 'system_')]
class SystemActionsController extends ApiController
{
    #[Route(path: '/list', name: 'list', methods: ['GET'])]
    public function listActions(): Response
    {
        return $this->render('system/_system_actions.html.twig');
    }
}
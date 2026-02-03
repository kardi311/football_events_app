<?php

namespace App\Controller;

use App\Message\AbstractEventMessage;
use App\ValueResolver\EventValueResolver;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

final class MatchEventController extends AbstractController
{
    //@todo remove get
    #[Route('/event', name: 'app_match_event', methods: ['POST', 'GET' ])]
    public function index(
        #[MapRequestPayload(resolver: EventValueResolver::class)] AbstractEventMessage $event,
        MessageBusInterface $messageBus
    ): JsonResponse
    {
        $messageBus->dispatch($event);

        return $this->json([
            'success' => true ,
        ]);
    }
}

<?php

namespace App\Controller;

use App\Exception\InvalidApiRequestException;
use App\Message\AbstractEventMessage;
use App\ValueResolver\EventValueResolver;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Attribute\Route;

final class MatchEventController extends AbstractController
{
    //@todo remove get
    #[Route('/event', name: 'app_match_event', methods: ['POST'])]
    public function index(
        #[MapRequestPayload(resolver: EventValueResolver::class)] AbstractEventMessage $event,
        MessageBusInterface $messageBus
    ): JsonResponse
    {
        try {
            $envelope = $messageBus->dispatch($event);
        } catch (\Throwable $exception) {
            return $this->json(['error' => $exception->getMessage()], 400);
        }

        $handledStamp = $envelope->last(HandledStamp::class);
        $eventResult = $handledStamp->getResult();

        return $this->json([
            'status' => 'success',
            'message' => 'Event saved successfully',
            'event' => $eventResult
        ]);
    }
}

<?php
declare(strict_types=1);

namespace App\ValueResolver;

use App\Entity\AbstractEvent;
use App\Entity\FoulEvent;
use App\Message\AbstractEventMessage;
use App\Message\FoulEventMessage;
use App\PayloadValidator\FoulEventValidator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class EventValueResolver implements ValueResolverInterface
{
    public function __construct(private readonly FoulEventValidator $foulEventValidator)
    {
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $argumentType = $argument->getType();
        if ($argumentType !== AbstractEventMessage::class) {
            // @todo throw proper exception
            return [];
        }

        $payload = $request->query->all();

        if (!isset($payload['type'])) {
            throw new \InvalidArgumentException('Event type is required');
        }

        switch ($payload['type']) {
            case FoulEvent::EVENT_TYPE:
                $this->foulEventValidator->validate($payload);
                return [FoulEventMessage::fromPayload($payload)];

        }

        // @todo add proper exception
        throw new \Exception('unsupported type');
    }
}

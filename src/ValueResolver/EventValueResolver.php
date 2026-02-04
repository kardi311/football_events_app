<?php
declare(strict_types=1);

namespace App\ValueResolver;

use App\Entity\FoulEvent;
use App\Entity\GoalEvent;
use App\Exception\InvalidApiRequestException;
use App\Message\AbstractEventMessage;
use App\Message\FoulEventMessage;
use App\Message\GoalEventMessage;
use App\PayloadValidator\FoulEventValidator;
use App\PayloadValidator\GoalEventValidator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

class EventValueResolver implements ValueResolverInterface
{
    public function __construct(
        private readonly FoulEventValidator $foulEventValidator,
        private readonly GoalEventValidator $goalEventValidator
    ) {
    }

    /**
     * @param Request $request
     * @param ArgumentMetadata $argument
     * @return AbstractEventMessage[]
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $argumentType = $argument->getType();
        if ($argumentType !== AbstractEventMessage::class) {
            // unsupported
            return [];
        }

        $payload = $request->getPayload()->all();

        if (empty($payload)) {
            throw new InvalidApiRequestException('Invalid JSON');
        }

        if (!isset($payload['type'])) {
            throw new InvalidApiRequestException('Event type is required');
        }

        switch ($payload['type']) {
            case FoulEvent::EVENT_TYPE:
                $this->foulEventValidator->validate($payload);
                return [FoulEventMessage::fromPayload($payload)];
            case GoalEvent::EVENT_TYPE:
                $this->goalEventValidator->validate($payload);
                return [GoalEventMessage::fromPayload($payload)];
        }

        throw new InvalidApiRequestException('unsupported type');
    }
}

<?php

namespace Test\Ecotone\Messaging\Fixture\InterceptorsOrdering;

use Ecotone\Messaging\Attribute\Parameter\Reference;
use Ecotone\Modelling\Attribute\Aggregate;
use Ecotone\Modelling\Attribute\CommandHandler;
use Ecotone\Modelling\Attribute\Identifier;
use Ecotone\Modelling\WithEvents;

#[Aggregate]
class InterceptorOrderingAggregate
{
    use WithEvents;

    public function __construct(
        #[Identifier] private string $id,
    )
    {
        $this->recordThat(new CreatedEvent());
    }


    #[CommandHandler(routingKey: "endpoint")]
    public static function factory(#[Reference] InterceptorOrderingStack $stack): self
    {
        $stack->add("factory");
        return new self($metadata["aggregate.id"] ?? "id");
    }

    #[CommandHandler(routingKey: 'endpointFactoryWithOutput', outputChannelName: 'internal-channel')]
    public static function factoryWithOutput(#[Reference] InterceptorOrderingStack $stack): self
    {
        $stack->add('factory');
        return new self($metadata['aggregate.id'] ?? 'id');
    }

    #[CommandHandler(routingKey: "endpoint")]
    public function action(#[Reference] InterceptorOrderingStack $stack): void
    {
        $stack->add("action");
    }

    #[CommandHandler(routingKey: "actionVoid")]
    public function actionVoid(#[Reference] InterceptorOrderingStack $stack): void
    {
        $stack->add("action");
    }

    #[CommandHandler(routingKey: 'endpointWithOutput', outputChannelName: 'internal-channel')]
    public function actionWithOutputChannel(#[Reference] InterceptorOrderingStack $stack): mixed
    {
        $stack->add('action');

        return "something";
    }
}
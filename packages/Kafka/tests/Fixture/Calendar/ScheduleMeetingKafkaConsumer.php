<?php

declare(strict_types=1);

namespace Test\Ecotone\Kafka\Fixture\Calendar;

use Ecotone\Kafka\Attribute\KafkaConsumer;
use Ecotone\Modelling\Attribute\QueryHandler;

final class ScheduleMeetingKafkaConsumer
{
    /**
     * @var ScheduleMeeting[]
     */
    private array $receivedMeetings = [];

    #[KafkaConsumer(
        'kafka_consumer_schedule_meeting',
        'testTopic'
    )]
    public function handle(ScheduleMeeting $scheduleMeeting): void
    {
        $this->receivedMeetings[] = $scheduleMeeting;
    }

    /**
     * @return ScheduleMeeting[]
     */
    #[QueryHandler('getScheduledMeetings')]
    public function getScheduledMeetings(): array
    {
        return $this->receivedMeetings;
    }
}

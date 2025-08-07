<?php

namespace App\Services;

use App\Http\Resources\PublicationMetadataResource;
use App\Models\PublicationMetadata;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class AmqpPublicationPublisher
{
    public function __construct(public PublicationMetadata $publication) {}

    public function publishTopic()
    {
        $resource = new PublicationMetadataResource($this->publication);
        $data = $resource->toJson();

        $host = config('RABBITMQ_HOST', 'rabbitmq');
        $port = config('RABBITMQ_PORT', 5672);
        $user = config('RABBITMQ_USER');
        $password = config('RABBITMQ_PASSWORD');

        $connection = new AMQPStreamConnection($host, $port, $user, $password);
        $channel = $connection->channel();

        $channel->exchange_declare('publications', 'topic', false, true, false);

        $message = new AMQPMessage($data);

        $channel->basic_publish($message, 'publications', 'publication.metadata.published');
        $channel->close();
        $connection->close();
    }
}

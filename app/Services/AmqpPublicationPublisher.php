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

        $host = config('services.rabbitmq.host');
        $port = config('services.rabbitmq.port');
        $user = config('services.rabbitmq.user');
        $password = config('services.rabbitmq.password');

        $connection = new AMQPStreamConnection($host, $port, $user, $password);
        $channel = $connection->channel();

        $channel->exchange_declare('publications', 'topic', false, true, false);

        $message = new AMQPMessage($data);

        $channel->basic_publish($message, 'publications', 'publication.metadata.published');
        $channel->close();
        $connection->close();
    }
}

<?php

declare(strict_types=1);

namespace App\Core\Api\Events;

use App\Core\Events\RespondEvent;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class SerializeListener
{
    public function __invoke(RespondEvent $respondEvent)
    {
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));

        $serializer = new Serializer(
            [new DateTimeNormalizer(), new ObjectNormalizer($classMetadataFactory)],
            [new JsonEncoder()]
        );

        $controllerResult = $respondEvent->getControllerResult();

        if (is_array($controllerResult) || is_object($controllerResult)) {
            header('Content-Type: application/json');

            $respondEvent->setControllerResult(
                $serializer->serialize($controllerResult, 'json')
            );
        }
    }
}

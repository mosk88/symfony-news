<?php

namespace App\Serializer\Normalizer;

use App\Entity\Article;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ArticleNormalizer implements NormalizerInterface
{
    public function __construct(
        #[Autowire(service: 'serializer.normalizer.object')]
        private NormalizerInterface $normalizer,
        private UrlGeneratorInterface $router,
    ) {
    }

    public function normalize($object, ?string $format = null, array $context = []): array
    {
        $data = $this->normalizer->normalize($object, $format, $context);

        // TODO: add, edit, or delete some data

        if (!$object instanceof Article) {
            return $data;
        }

        $data['url'] = $this->router->generate(
            'api_article_item',
            ['id' => $object->getId()],
            UrlGeneratorInterface::ABSOLUTE_URL
        );

        return $data;

       
    }

    public function supportsNormalization($data, ?string $format = null, array $context = []): bool
    {

        return $data instanceof Article;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [Article::class => true];
    }
}

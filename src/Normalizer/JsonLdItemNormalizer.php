<?php


namespace App\Normalizer;


use ApiPlatform\Core\Api\OperationType;
use ApiPlatform\Core\Api\UrlGeneratorInterface;
use ApiPlatform\Core\Bridge\Symfony\Routing\RouteNameGenerator;
use ApiPlatform\Core\JsonLd\Serializer\ItemNormalizer;
use ApiPlatform\Core\Metadata\Resource\Factory\ResourceMetadataFactoryInterface;
use ApiPlatform\Core\PathResolver\OperationPathResolverInterface;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerInterface;

class JsonLdItemNormalizer implements NormalizerInterface, SerializerAwareInterface
{
    /**
     * @var ItemNormalizer
     */
    private $decorated;

    /**
     * @var ResourceMetadataFactoryInterface
     */
    private $resourceMetadataFactory;
    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;
    /**
     * @var ExpressionLanguage
     */
    private $expressionLanguage;

    public function __construct(ItemNormalizer $decorated, ResourceMetadataFactoryInterface $resourceMetadataFactory, UrlGeneratorInterface $urlGenerator)
    {
        $this->decorated = $decorated;
        $this->resourceMetadataFactory = $resourceMetadataFactory;
        $this->urlGenerator = $urlGenerator;
        $this->expressionLanguage = new ExpressionLanguage();
    }

    public function normalize($object, string $format = null, array $context = [])
    {
        $data = $this->decorated->normalize($object, $format, $context);

        $links = $this->getLinks();

        if (!empty($links)) {
            $data['_links'] = $links;
        }

        return $data;
    }

    public function supportsNormalization($data, string $format = null)
    {
        return $this->decorated->supportsNormalization($data, $format);
    }

    public function setSerializer(SerializerInterface $serializer)
    {
        if ($this->decorated instanceof SerializerAwareInterface) {
            $this->decorated->setSerializer($serializer);
        }
    }

    private function getLinks() : array
    {
        $links = [];

        $resourceMetaData = $this->resourceMetadataFactory->create('App\Entity\Cheese');

        $resourceShortName = $resourceMetaData->getShortName();

        // TODO: How to get a Path when it's not explicitly set?

        foreach ($resourceMetaData->getItemOperations() as $operationName => $operation) {
            $a = 5;
        }

        foreach ($resourceMetaData->getCollectionOperations() as $operationName => $operation) {
            // Does each operation have "path" ?
            $links[$operationName] = [
                'href'  => 'TODO: How to get a full path?',
                'meta'  => [
                    'method'    => $operation['method']
                ]
            ];
        }

        return $links;
    }


}
<?php

namespace ShyimAttributeTransformer\Components\Entity;

use Shopware\Bundle\StoreFrontBundle\Service\ContextServiceInterface;
use Shopware\Bundle\StoreFrontBundle\Service\Core\MediaService;
use Shopware\Components\Compatibility\LegacyStructConverter;
use ShyimAttributeTransformer\Components\ModelTransformer;

/**
 * Class MediaTransformer
 * @author Soner Sayakci <shyim@posteo.de>
 */
class MediaTransformer extends ModelTransformer implements EntityTransformer
{
    /**
     * @var MediaService
     */
    private $mediaService;

    /**
     * @var LegacyStructConverter
     */
    private $converter;

    /**
     * @var ContextServiceInterface
     */
    private $contextService;

    /**
     * MediaTransformer constructor.
     * @param MediaService $mediaService
     * @param LegacyStructConverter $converter
     * @param ContextServiceInterface $contextService
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function __construct(MediaService $mediaService, LegacyStructConverter $converter, ContextServiceInterface $contextService)
    {
        parent::__construct();
        $this->mediaService = $mediaService;
        $this->converter = $converter;
        $this->contextService = $contextService;
    }

    /**
     * @author Soner Sayakci <shyim@posteo.de>
     */
    public function resolve()
    {
        if (!empty($this->ids)) {
            $medias = $this->mediaService->getList($this->ids, $this->contextService->getShopContext());

            foreach ($medias as $media) {
                $this->data[$media->getId()] = $this->converter->convertMediaStruct($media);
            }

            $this->ids = [];
        }
    }

    /**
     * @return string
     */
    public function getEntity(): string
    {
        return 's_media';
    }
}
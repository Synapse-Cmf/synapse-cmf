<?php

namespace Synapse\Cmf\Bundle\Loader\Orm;

use Majora\Framework\Loader\Bridge\Doctrine\AbstractDoctrineLoader;
use Majora\Framework\Loader\Bridge\Doctrine\DoctrineLoaderTrait;
use Majora\Framework\Loader\LazyLoaderInterface;
use Synapse\Cmf\Bundle\Entity\Orm\Template;
use Synapse\Cmf\Bundle\Entity\Orm\Zone;
use Synapse\Cmf\Bundle\Loader\Orm\ZoneOrmLoader as ZoneLoader;
use Synapse\Cmf\Framework\Theme\ContentType\Loader\LoaderInterface as ContentTypeLoader;
use Synapse\Cmf\Framework\Theme\ContentType\Model\ContentTypeInterface;
use Synapse\Cmf\Framework\Theme\Content\Entity\Content;
use Synapse\Cmf\Framework\Theme\TemplateType\Entity\TemplateType;
use Synapse\Cmf\Framework\Theme\TemplateType\Loader\LoaderInterface as TemplateTypeLoader;
use Synapse\Cmf\Framework\Theme\Template\Loader\LoaderInterface as TemplateLoaderInterface;
use Synapse\Cmf\Framework\Theme\Template\Model\TemplateInterface;
use Synapse\Cmf\Framework\Theme\ZoneType\Model\ZoneTypeInterface;
use Synapse\Cmf\Framework\Theme\Zone\Domain\ZoneDomain;
use Synapse\Cmf\Framework\Theme\Zone\Entity\ZoneCollection;

/**
 * Template loader override to register lazy loaders.
 */
class TemplateOrmLoader extends AbstractDoctrineLoader implements TemplateLoaderInterface, LazyLoaderInterface
{
    use DoctrineLoaderTrait;

    /**
     * @var TemplateTypeLoader
     */
    protected $templateTypeLoader;

    /**
     * @var ContentTypeLoader
     */
    protected $contentTypeLoader;

    /**
     * @var ZoneLoader
     */
    protected $zoneLoader;

    /**
     * @var ZoneDomain
     */
    protected $zoneDomain;

    /**
     * Construct.
     *
     * @param TemplateTypeLoader $templateTypeLoader
     * @param ContentTypeLoader  $contentTypeLoader
     * @param ZoneLoader         $zoneLoader
     * @param ZoneDomain         $zoneDomain
     */
    public function __construct(
        TemplateTypeLoader $templateTypeLoader,
        ContentTypeLoader $contentTypeLoader,
        ZoneLoader $zoneLoader,
        ZoneDomain $zoneDomain
    ) {
        $this->templateTypeLoader = $templateTypeLoader;
        $this->contentTypeLoader = $contentTypeLoader;
        $this->zoneLoader = $zoneLoader;
        $this->zoneDomain = $zoneDomain;
    }

    /**
     * @see LazyLoaderInterface::getLoadingDelegates()
     */
    public function getLoadingDelegates()
    {
        return array(
            'contentType' => function (Template $template) {
                return $this->contentTypeLoader->retrieve($template->getContentTypeName());
            },
        );
    }

    /**
     * Loader invocable handler as proxy for template factory method
     *
     * @param Template $template
     *
     * @return Template
     */
    public function __invoke(Template $template)
    {
        // fetch TemplateType
        if (!$templateType = $this->templateTypeLoader->retrieve($template->getTemplateTypeId())) {
            throw new \RuntimeException(sprintf(
                'Unavailable to load template type "%s", from template "%s". Maybe your data and configurations have diverged, available templates types are : %s. Please check your themes configurations.',
                $template->getTemplateTypeId(),
                $template->getId(),
                $this->templateTypeLoader->retrieveAll()->display('id')
            ));
        }

        // due to Doctrine joined hydration concurrency with events,
        // we have to direct call zone hydration from another request
        $templateZones = $this->zoneLoader->retrieveForTemplate($template);

        $template
            ->setTemplateType($templateType)
            ->setZones(new ZoneCollection(
                $templateType->getZoneTypes()
                    ->map(function (ZoneTypeInterface $zoneType) use ($template, $templateZones) {
                        return $templateZones->search(array('zoneType' => $zoneType))->first()
                            ?: $this->zoneDomain->create($zoneType)
                        ;
                    })
                    ->toArray()
            ))
        ;
    }

    /**
     * @see TemplateLoaderInterface::retrieveDisplayable()
     */
    public function retrieveDisplayable(TemplateType $templateType, Content $content)
    {
        $queryBuilder = $this->getEntityRepository()
            ->createQueryBuilder('template')
        ;

        $displayableTemplates = $this->toEntityCollection(
            $queryBuilder
                ->andWhere('template.templateTypeId = :templateTypeId')
                ->andWhere('template.contentTypeName = :contentTypeName')
                ->andWhere($queryBuilder->expr()->orX(
                   $queryBuilder->expr()->eq('template.contentId', ':contentId'),
                   $queryBuilder->expr()->isNull('template.contentId')
                ))
                ->setParameters(array(
                    'templateTypeId' => $templateType->getId(),
                    'contentTypeName' => $content->getType()->getName(),
                    'contentId' => $content->getContentId(),
                ))
            ->getQuery()
                ->getResult()
        );
        if ($displayableTemplates->isEmpty()) {
            return;
        }
        if ($displayableTemplates->count() == 1) {
            return $displayableTemplates->first();
        }

        // local by default (with hydrated global)
        return $displayableTemplates
                ->search(array('scope' => TemplateInterface::LOCAL_SCOPE))->first()
            ->setGlobalTemplate(
                $displayableTemplates->search(array('scope' => TemplateInterface::GLOBAL_SCOPE))->first()
            )
        ;
    }

    /**
     * @see TemplateLoaderInterface::retrieveLocal()
     */
    public function retrieveLocal(TemplateType $templateType, Content $content)
    {
        $queryBuilder = $this->createQuery('template');

        return $queryBuilder
                ->andWhere('template.templateTypeId = :templateTypeId')
                ->andWhere('template.contentTypeName = :contentTypeName')
                ->andWhere('template.contentId = :contentId')
                ->setParameters(array(
                    'templateTypeId' => $templateType->getId(),
                    'contentTypeName' => $content->getType()->getName(),
                    'contentId' => $content->getContentId(),
                ))
            ->getQuery()
                ->getOneOrNullResult()
        ;
    }

    /**
     * @see TemplateLoaderInterface::retrieveGlobal()
     */
    public function retrieveGlobal(TemplateType $templateType, ContentTypeInterface $contentType)
    {
        $queryBuilder = $this->createQuery('template');

        return $queryBuilder
                ->andWhere('template.templateTypeId = :templateTypeId')
                ->andWhere('template.contentTypeName = :contentTypeName')
                ->andWhere('template.contentId is null')
                ->setParameters(array(
                    'templateTypeId' => $templateType->getId(),
                    'contentTypeName' => $contentType->getName(),
                ))
            ->getQuery()
                ->getOneOrNullResult()
        ;
    }
}

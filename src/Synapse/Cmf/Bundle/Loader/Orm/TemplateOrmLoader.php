<?php

namespace Synapse\Cmf\Bundle\Loader\Orm;

use Majora\Framework\Loader\Bridge\Doctrine\AbstractDoctrineLoader;
use Majora\Framework\Loader\Bridge\Doctrine\DoctrineLoaderTrait;
use Majora\Framework\Loader\LazyLoaderInterface;
use Synapse\Cmf\Bundle\Entity\Orm\Template;
use Synapse\Cmf\Framework\Theme\ContentType\Loader\LoaderInterface as ContentTypeLoader;
use Synapse\Cmf\Framework\Theme\ContentType\Model\ContentTypeInterface;
use Synapse\Cmf\Framework\Theme\Content\Entity\Content;
use Synapse\Cmf\Framework\Theme\TemplateType\Entity\TemplateType;
use Synapse\Cmf\Framework\Theme\TemplateType\Loader\LoaderInterface as TemplateTypeLoader;
use Synapse\Cmf\Framework\Theme\Template\Loader\LoaderInterface as TemplateLoaderInterface;
use Synapse\Cmf\Framework\Theme\Template\Model\TemplateInterface;

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
     * Construct.
     *
     * @param TemplateTypeLoader $templateTypeLoader
     * @param ContentTypeLoader  $contentTypeLoader
     */
    public function __construct(
        TemplateTypeLoader $templateTypeLoader,
        ContentTypeLoader $contentTypeLoader
    ) {
        $this->templateTypeLoader = $templateTypeLoader;
        $this->contentTypeLoader = $contentTypeLoader;
    }

    /**
     * @see LazyLoaderInterface::getLoadingDelegates()
     */
    public function getLoadingDelegates()
    {
        return array(
            'templateType' => function (Template $template) {
                return $this->templateTypeLoader->retrieve($template->getTemplateTypeId());
            },
            'contentType' => function (Template $template) {
                return $this->contentTypeLoader->retrieve($template->getContentTypeName());
            },
        );
    }

    /**
     * Overriden to always load zones and components.
     *
     * @return QueryBuilder
     */
    protected function createQuery($alias)
    {
        return $this->getEntityRepository()->createQueryBuilder($alias)
            ->select(array($alias, 'zones', 'components'))
                ->innerJoin($alias.'.zones', 'zones')
                ->leftJoin('zones.components', 'components')
            ->addOrderBy('components.ranking', 'asc')
        ;
    }

    /**
     * @see TemplateLoaderInterface::retrieveDisplayable()
     */
    public function retrieveDisplayable(TemplateType $templateType, Content $content)
    {
        $queryBuilder = $this->createQuery('template');

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

<?php

namespace Synapse\Cmf\Framework\Theme\ContentType\Entity;

use Majora\Framework\Normalizer\Model\NormalizableTrait;
use Synapse\Cmf\Framework\Theme\ContentType\Model\ContentTypeInterface;
use Synapse\Cmf\Framework\Theme\Content\Provider\ContentProviderInterface as ContentProvider;

/**
 * ContentType entity class.
 */
class ContentType implements ContentTypeInterface
{
    use NormalizableTrait;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $contentClass;

    /**
     * @var ContentProviderInterface
     */
    protected $contentProvider;

    /**
     * @see NormalizableInterface::getScopes()
     */
    public static function getScopes()
    {
        return array(
            'id' => 'id',
            'default' => array('id'),
        );
    }

    /**
     * Returns ContentType id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Define ContentType id.
     *
     * @param int $id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Returns ContentType name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Define ContentType name.
     *
     * @param string $name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Returns ContentType content class.
     *
     * @return string
     */
    public function getContentClass()
    {
        return $this->contentClass;
    }

    /**
     * Define ContentType content class.
     *
     * @param string $contentClass
     *
     * @return self
     */
    public function setContentClass($contentClass)
    {
        $this->contentClass = $contentClass;

        return $this;
    }

    /**
     * Retrieve a Content from given id at defined content loader.
     *
     * @param int $id
     *
     * @return ContentInterface|null
     */
    public function retrieveContent($id)
    {
        return $this->contentProvider->retrieveContent($id);
    }

    /**
     * Define ContentType content loader.
     *
     * @param ContentProvider $contentProvider
     *
     * @return self
     */
    public function setContentLoader(ContentProvider $contentProvider)
    {
        $this->contentProvider = $contentProvider;

        return $this;
    }
}

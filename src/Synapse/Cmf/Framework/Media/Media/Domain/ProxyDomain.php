<?php

namespace Synapse\Cmf\Framework\Media\Media\Domain;

use Symfony\Component\HttpFoundation\File\File as PhysicalFile;
use Synapse\Cmf\Framework\Media\Media\Domain\Exception\UnsupportedFileException;

/**
 * Media domain implementation which proxy other media domain, use cases
 * are forwarded to proper domains function of physical file type.
 */
class ProxyDomain implements DomainInterface
{
    /**
     * @var DomainInterface[]
     */
    protected $mediaDomainsMap;

    /**
     * Construct.
     *
     * @param array $mediaDomainsMap
     */
    public function __construct(array $mediaDomainsMap = array())
    {
        foreach ($mediaDomainsMap as $extensions => $domain) {
            $this->registerMediaDomain(explode(',', $extensions), $domain);
        }
    }

    /**
     * Register a media domain for given file extension set.
     *
     * @param string|array    $extensions
     * @param DomainInterface $mediaDomain
     */
    public function registerMediaDomain($extensions, DomainInterface $mediaDomain)
    {
        foreach ((array) $extensions as $extensions) {
            $this->mediaDomainsMap[strtolower($extensions)] = $mediaDomain;
        }
    }

    /**
     * Fetch and return domain matching given file extension.
     *
     * @param string $extension
     *
     * @return DomainInterface
     *
     * @throws UnsupportedFileException If given extension isnt supported
     */
    private function fetchDomain($extension)
    {
        if (!array_key_exists($extension = strtolower($extension), $this->mediaDomainsMap)) {
            throw new UnsupportedFileException(sprintf(
                'Extension ".%s" isnt supported by Media component, only ["%s"] are.',
                $extension,
                array_keys($this->mediaDomainsMap)
            ));
        }

        return $this->mediaDomainsMap[$extension];
    }

    /**
     * @see DomainInterface::upload()
     */
    public function upload(PhysicalFile $file, $name = null)
    {
        return $this->fetchDomain($file->guessExtension())
            ->upload($file, $name)
        ;
    }

    /**
     * @see DomainInterface::upload()
     */
    public function create(PhysicalFile $file, $name = null)
    {
        return $this->fetchDomain($file->guessExtension())
            ->create($file, $name)
        ;
    }
}

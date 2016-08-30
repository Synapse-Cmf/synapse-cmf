<?php

namespace Synapse\Page\Bundle\Domain\Page;

use Synapse\Page\Bundle\Entity\Page;

/**
 * Interface for Page domain use cases.
 */
interface DomainInterface
{
    /**
     * Triggers Page creation process.
     *
     * @param string $name      Page name (shouldnt be used in front cases)
     * @param Page   $parent    Parent page into tree (optional : fill with null to create homepage)
     * @param string $path      Base url for page (optional : fill with blank to create landings)
     * @param bool   $online    Page online state
     * @param string $title     Page <title> and <h1>title</h1>
     * @param array  $meta      Optionnal html meta key value map
     * @param array  $openGraph Optionnal open graph meta key value map
     *
     * @return Page
     */
    public function create(
        $name,
        Page $parent = null,
        $path = '',
        $online = false,
        $title = null,
        array $meta = array(),
        array $openGraph = array()
    );

    /**
     * Triggers Page edition process.
     *
     * @param Page   $page
     * @param string $name      Page name (shouldnt be used in front cases)
     * @param bool   $online    Page online state
     * @param string $title     Page <title> and <h1>title</h1>
     * @param array  $meta      Optionnal html meta key value map
     * @param array  $openGraph Optionnal open graph meta key value map
     *
     * @return Page
     */
    public function edit(
        Page $page,
        $name,
        $online = false,
        $title = null,
        array $meta = array(),
        array $openGraph = array()
    );

    /**
     * Triggers Page deletion process.
     *
     * @param Page $page
     *
     * @return mixed
     */
    public function delete(Page $page);
}

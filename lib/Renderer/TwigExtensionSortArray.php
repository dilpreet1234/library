<?php
/*
 * Copyright (c) Arnaud Ligny <arnaud@ligny.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace PHPoole\Renderer;

use PHPoole\Page\Collection as PageCollection;
use PHPoole\Page\Page;

/**
 * Class TwigExtensionSortArray
 * @package PHPoole\Renderer
 */
class TwigExtensionSortArray extends \Twig_Extension
{
    /**
     * Name of this extension
     *
     * @return string
     */
    public function getName()
    {
        return 'sort_array';
    }

    /**
     * Returns a list of filters.
     *
     * @return array
     */
    public function getFilters()
    {
        $filters = array(
            new \Twig_SimpleFilter('sortByWeight', array($this, 'sortByWeight')),
            new \Twig_SimpleFilter('sortByDate', array($this, 'sortByDate')),
            new \Twig_SimpleFilter('bySection', array($this, 'bySection')),
        );

        return $filters;
    }

    /**
     * Sort by weight
     *
     * @param $array
     * @return array
     */
    function sortByWeight($array)
    {
        usort($array, function($a, $b) {
            if (!isset($a['weight']) || !isset($b['weight'])) {
                return 0;
            }
            if ($a['weight'] == $b['weight']) {
                return 0;
            }
            return ($a['weight'] < $b['weight']) ? -1 : 1;
        });

        return $array;
    }

    /**
     * Sort by date
     *
     * @param $array
     * @return array
     */
    function sortByDate($array)
    {
        $callback = function($a, $b) {
            if (!isset($a['date']) || !isset($b['date'])) {
                return 0;
            }
            if ($a['date'] == $b['date']) {
                return 0;
            }
            return ($a['date'] > $b['date']) ? -1 : 1;
        };

        if ($array instanceof PageCollection) {
            $array->usort($callback);
        } else {
            if (is_array($array)) {
                usort($array, $callback);
            }
        }

        return $array;
    }

    /**
     * Filter by section
     *
     * @param $pages
     * @param $section
     * @return array
     */
    function bySection($pages, $section)
    {
        $filtered = [];

        foreach($pages as $page) {
            if ($page instanceof Page) {
                if ($page->getSection() == $section) {
                    $filtered[] = $page;
                }
            }
        }

        return $filtered;
    }
}
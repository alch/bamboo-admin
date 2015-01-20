<?php

/**
 * This file is part of the Elcodi package.
 *
 * Copyright (c) 2014 Elcodi.com
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Feel free to edit as you please, and have fun.
 *
 * @author Marc Morera <yuhu@mmoreram.com>
 * @author Aldo Chiecchia <zimage@tiscali.it>
 */

namespace Elcodi\Admin\AdminProductBundle\Controller\Stats;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Elcodi\Admin\AdminCoreBundle\Controller\Abstracts\AbstractStatsController;

/**
 * Class ManufacturerStatsController
 *
 * @Route(
 *      path = "/manufacturers/stats"
 * )
 */
class ManufacturerStatsController extends AbstractStatsController
{
    /**
     * Get count of all elements
     *
     * @return mixed
     *
     * @Route(
     *      path = "/total",
     *      name = "admin_manufacturer_stats_total"
     * )
     * @Template("AdminCoreBundle:Stats:total.html.twig")
     * @Method({"GET"})
     */
    public function totalStatsAction()
    {
        return [
            'total' => $this->getTotalStats('elcodi.core.product.entity.manufacturer.class'),
        ];
    }

    /**
     * Get last month elements count
     *
     * @return mixed
     *
     * @Route(
     *      path = "/monthly",
     *      name = "admin_manufacturer_stats_monthly"
     * )
     * @Template("AdminCoreBundle:Stats:monthly.html.twig")
     * @Method({"GET"})
     */
    public function monthlyStatsAction()
    {
        return [
            'total' => $this->getMonthlyStats('elcodi.core.product.entity.manufacturer.class'),
        ];
    }

    /**
     * Get today elements count
     *
     * @return mixed
     *
     * @Route(
     *      path = "/daily",
     *      name = "admin_manufacturer_stats_daily"
     * )
     * @Template("AdminCoreBundle:Stats:daily.html.twig")
     * @Method({"GET"})
     */
    public function dailyStatsAction()
    {
        return [
            'total' => $this->getDailyStats('elcodi.core.product.entity.manufacturer.class'),
        ];
    }
}

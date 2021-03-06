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

namespace Elcodi\Admin\AdminCoreBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class IndexController
 *
 * @Route(
 *      path = "/",
 * )
 */
class HomeController extends Controller
{
    /**
     * Index action
     *
     * @Route(
     *      path = "",
     *      name = "admin_homepage"
     * )
     * @Template
     */
    public function indexAction()
    {
        return [];
    }
}

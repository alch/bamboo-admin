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

namespace Elcodi\AdminMediaBundle\Controller\Component;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Elcodi\AdminCoreBundle\Controller\Abstracts\AbstractAdminController;

/**
 * Class ImageComponentController
 *
 * @Route(
 *      path = "/media/image"
 * )
 */
class ImageComponentController extends AbstractAdminController
{
    /**
     * Component for entity list.
     *
     * As a component, this action should not return all the html macro, but
     * only the specific component
     *
     * @return array Result
     *
     * @Route(
     *      path = "s/list/component",
     *      name = "admin_image_list_component",
     *      methods = {"GET"}
     * )
     * @Template("AdminMediaBundle:Image:listComponent.html.twig")
     */
    public function listComponentAction()
    {
        $images = $this
            ->get('elcodi.repository.image')
            ->findAll();

        return [
            'images' => $images,
        ];
    }
}

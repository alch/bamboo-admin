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

namespace Elcodi\Admin\AdminCartCouponBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class CartCouponType
 */
class CartCouponType extends AbstractType
{
    /**
     * Buildform function
     *
     * @param FormBuilderInterface $builder the formBuilder
     * @param array                $options the options for this form
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cart', 'entity', array(
                'class'    => 'Elcodi\Component\Cart\Entity\Cart',
                'required' => false,
                'label'    => 'cart',
                'multiple' => false,
            ))
            ->add('coupon', 'entity', array(
                'class'    => 'Elcodi\Component\Coupon\Entity\Coupon',
                'required' => false,
                'label'    => 'coupon',
                'multiple' => false,
            ));
    }

    /**
     * Return unique name for this form
     *
     * @return string
     */
    public function getName()
    {
        return 'elcodi_admin_cartcoupon_form_type_cart_coupon';
    }
}

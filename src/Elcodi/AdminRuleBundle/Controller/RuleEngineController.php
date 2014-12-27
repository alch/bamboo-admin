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

namespace Elcodi\AdminRuleBundle\Controller;

use Doctrine\ORM\Mapping\ClassMetadata;
use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use Elcodi\AdminCoreBundle\Controller\Abstracts\AbstractAdminController;
use Elcodi\Component\Rule\Entity\Interfaces\ExpressionInterface;
use Elcodi\Component\Rule\Entity\Interfaces\RuleInterface;

/**
 * Class Controller for Rule
 *
 * @Route(
 *      path = "/rule",
 * )
 */
class RuleEngineController extends AbstractAdminController
{
    /**
     * Rule engine
     *
     * @return array Result
     *
     * @Route(
     *      path = "/engine",
     *      name = "admin_rule_engine"
     * )
     * @Method({"GET"})
     * @Template
     */
    public function engineAction()
    {
        return [
            'context' => [
                'customer' => 'Elcodi\Component\User\Entity\Interfaces\CustomerInterface',
                'cart'     => 'Elcodi\Component\Cart\Entity\Interfaces\CartInterface',
                'coupon'   => 'Elcodi\Component\Coupon\Entity\Interfaces\CouponInterface',
            ],
        ];
    }

    /**
     * Rule engine
     *
     * @return array Result
     *
     * @Route(
     *      path = "/engine/submit",
     *      name = "admin_rule_engine_submit"
     * )
     * @Method({"POST"})
     *
     * @EntityAnnotation(
     *      name = "expression",
     *      class = {
     *          "factory" = "elcodi.core.rule.factory.expression",
     *      }
     * )
     * @EntityAnnotation(
     *      name = "rule",
     *      class = {
     *          "factory" = "elcodi.core.rule.factory.rule",
     *      }
     * )
     */
    public function engineSubmitionAction(
        Request $request,
        ExpressionInterface $expression,
        RuleInterface $rule
    )
    {
        $data = $request->request->all();
        $builtExpression = '';

        foreach ($data['comparation'] as $comparation) {

            foreach ($comparation['comparated'] as $comparated) {

                $builtExpression .= $comparated . '.';
            }

            $builtExpression = trim($builtExpression, '.');

            $builtExpression .= " " . $comparation['comparator'] . " ";
            $builtExpression .= $comparation['comparable'];
        }

        $expression->setExpression($builtExpression);
        $ruleObjectManager = $this->get('elcodi.object_manager.rule');
        $ruleRepository = $this->get('elcodi.repository.rule');
        $ruleCode = $data['code'];

        $existingRule = $ruleRepository->findOneBy([
            'code' => $ruleCode
        ]);

        if ($existingRule instanceof RuleInterface) {

            $ruleCode .= rand(10000000, 99999999);
        }

        $rule
            ->setExpression($expression)
            ->setCode($ruleCode)
            ->setName($data['name'])
            ->setEnabled(true);

        $ruleObjectManager->persist($rule);
        $ruleObjectManager->flush($rule);

        echo $rule
            ->getExpression()
            ->getExpression();
        die();
    }

    /**
     * Rule engine API
     *
     * @return array Result
     *
     * @Route(
     *      path = "/engine/api/{namespace}",
     *      name = "admin_rule_engine_api"
     * )
     * @Method({"GET", "POST"})
     *
     * @JsonResponse()
     */
    public function apiAction($namespace)
    {
        $mappingProvider = $this->get('elcodi.mapping_provider');
        $implementationNamespace = $mappingProvider->getImplementation($namespace);

        /**
         * @var ClassMetadata $classMetadata
         */
        $classMetadata = $this
            ->getDoctrine()
            ->getManagerForClass($implementationNamespace)
            ->getClassMetadata($implementationNamespace);

        /**
         * Associations
         */
        $associations = [];
        foreach ($classMetadata->associationMappings as $fieldName => $fieldMetadata) {

            $collection = (bool) ($fieldMetadata['type'] & ClassMetadata::TO_MANY);

            $associations[$fieldName] = [
                'name'       => $fieldName,
                'namespace'  => $mappingProvider->getInterface($fieldMetadata['targetEntity']),
                'collection' => $collection,
            ];
        }

        return [
            'associations' => $associations,
            'fields'       => $classMetadata->fieldMappings,
        ];
    }
}

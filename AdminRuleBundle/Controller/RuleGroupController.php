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

namespace Elcodi\Admin\AdminRuleBundle\Controller;

use Doctrine\ORM\Tools\Pagination\Paginator;
use Exception;
use Mmoreram\ControllerExtraBundle\Annotation\Entity as EntityAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\Form as FormAnnotation;
use Mmoreram\ControllerExtraBundle\Annotation\JsonResponse;
use Mmoreram\ControllerExtraBundle\Annotation\Paginator as PaginatorAnnotation;
use Mmoreram\ControllerExtraBundle\ValueObject\PaginatorAttributes;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

use Elcodi\Admin\AdminCoreBundle\Controller\Abstracts\AbstractAdminController;
use Elcodi\Component\Core\Entity\Interfaces\EnabledInterface;
use Elcodi\Component\Rule\Entity\Interfaces\RuleGroupInterface;

/**
 * Class Controller for Rule
 *
 * @Route(
 *      path = "/rulegroup",
 * )
 */
class RuleGroupController extends AbstractAdminController
{
    /**
     * List elements of certain entity type.
     *
     * This action is just a wrapper, so should never get any data,
     * as this is component responsibility
     *
     * @param integer $page             Page
     * @param integer $limit            Limit of items per page
     * @param string  $orderByField     Field to order by
     * @param string  $orderByDirection Direction to order by
     *
     * @return array Result
     *
     * @Route(
     *      path = "s/{page}/{limit}/{orderByField}/{orderByDirection}",
     *      name = "admin_rule_group_list",
     *      requirements = {
     *          "page" = "\d*",
     *          "limit" = "\d*",
     *      },
     *      defaults = {
     *          "page" = "1",
     *          "limit" = "50",
     *          "orderByField" = "id",
     *          "orderByDirection" = "DESC",
     *      },
     * )
     * @Template
     * @Method({"GET"})
     */
    public function listAction(
        $page,
        $limit,
        $orderByField,
        $orderByDirection
    )
    {
        return [
            'page'             => $page,
            'limit'            => $limit,
            'orderByField'     => $orderByField,
            'orderByDirection' => $orderByDirection,
        ];
    }

    /**
     * Component for entity list.
     *
     * As a component, this action should not return all the html macro, but
     * only the specific component
     *
     * @param Paginator           $paginator           Paginator instance
     * @param PaginatorAttributes $paginatorAttributes Paginator Attributes
     * @param integer             $page                Page
     * @param integer             $limit               Limit of items per page
     * @param string              $orderByField        Field to order by
     * @param string              $orderByDirection    Direction to order by
     *
     * @return array Result
     *
     * @Route(
     *      path = "s/list/component/{page}/{limit}/{orderByField}/{orderByDirection}",
     *      name = "admin_rule_group_list_component",
     *      requirements = {
     *          "page" = "\d*",
     *          "limit" = "\d*",
     *      },
     *      defaults = {
     *          "page" = "1",
     *          "limit" = "50",
     *          "orderByField" = "id",
     *          "orderByDirection" = "DESC",
     *      },
     * )
     * @Template("AdminRuleBundle:RuleGroup:Component/listComponent.html.twig")
     * @Method({"GET"})
     *
     * @PaginatorAnnotation(
     *      class = "elcodi.core.rule.entity.rule_group.class",
     *      page = "~page~",
     *      limit = "~limit~",
     *      orderBy = {
     *          {"x", "~orderByField~", "~orderByDirection~"}
     *      }
     * )
     */
    public function listComponentAction(
        Paginator $paginator,
        PaginatorAttributes $paginatorAttributes,
        $page,
        $limit,
        $orderByField,
        $orderByDirection
    )
    {
        return [
            'paginator'        => $paginator,
            'page'             => $page,
            'limit'            => $limit,
            'orderByField'     => $orderByField,
            'orderByDirection' => $orderByDirection,
            'totalPages'       => $paginatorAttributes->getTotalPages(),
            'totalElements'    => $paginatorAttributes->getTotalElements(),
        ];
    }

    /**
     * View element action.
     *
     * This action is just a wrapper, so should never get any data,
     * as this is component responsibility
     *
     * @param Request $request Request
     * @param integer $id      Entity id
     *
     * @return array Result
     *
     * @Route(
     *      path = "/{id}",
     *      name = "admin_rule_group_view",
     *      requirements = {
     *          "id" = "\d*",
     *      }
     * )
     * @Template
     * @Method({"GET"})
     */
    public function viewAction($id)
    {
        return [
            'id' => $id,
        ];
    }

    /**
     * Component for entity view
     *
     * As a component, this action should not return all the html macro, but
     * only the specific component
     *
     * @param RuleGroupInterface $entity Entity to view
     *
     * @return array Result
     *
     * @Route(
     *      path = "/component/{id}",
     *      name = "admin_rule_group_view_component",
     *      requirements = {
     *          "id" = "\d*",
     *      }
     * )
     * @Template("AdminRuleBundle:RuleGroup:Component/viewComponent.html.twig")
     * @Method({"GET"})
     *
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "elcodi.core.rule.factory.rule_group",
     *      },
     *      mapping = {
     *          "id" = "~id~"
     *      }
     * )
     */
    public function viewComponentAction(RuleGroupInterface $entity)
    {
        return [
            'entity' => $entity,
        ];
    }

    /**
     * New element action
     *
     * This action is just a wrapper, so should never get any data,
     * as this is component responsibility
     *
     * @return array Result
     *
     * @Route(
     *      path = "/new",
     *      name = "admin_rule_group_new"
     * )
     * @Template
     * @Method({"GET"})
     */
    public function newAction()
    {
        return [];
    }

    /**
     * New element action
     *
     * As a component, this action should not return all the html macro, but
     * only the specific component
     *
     * @param FormView $formView Form view
     *
     * @return array Result
     *
     * @Route(
     *      path = "/new/component",
     *      name = "admin_rule_group_new_component"
     * )
     * @Template("AdminRuleBundle:RuleGroup:Component/newComponent.html.twig")
     * @Method({"GET"})
     *
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "elcodi.core.rule.factory.rule_group",
     *      }
     * )
     * @FormAnnotation(
     *      class = "elcodi_admin_rule_form_type_rule_group",
     *      name  = "formView",
     *      entity = "entity"
     * )
     */
    public function newComponentAction(FormView $formView)
    {
        return [
            'form' => $formView,
        ];
    }

    /**
     * Save new element action
     *
     * Should be POST
     *
     * @param RuleGroupInterface $entity  Entity to save
     * @param FormInterface      $form    Form view
     * @param boolean            $isValid Request handle is valid
     *
     * @return RedirectResponse Redirect response
     *
     * @Route(
     *      path = "/save",
     *      name = "admin_rule_group_save"
     * )
     * @Method({"POST"})
     *
     * @EntityAnnotation(
     *      class = {
     *          "factory" = "elcodi.core.rule.factory.rule_group",
     *      },
     *      persist = true
     * )
     * @FormAnnotation(
     *      class = "elcodi_admin_rule_form_type_rule_group",
     *      name  = "form",
     *      entity = "entity",
     *      handleRequest = true,
     *      validate = "isValid"
     * )
     */
    public function saveAction(
        RuleGroupInterface $entity,
        FormInterface $form,
        $isValid
    )
    {
        if ($isValid) {
            $this
                ->get('elcodi.object_manager.rule_group')
                ->flush($entity);
        }

        return $this->redirectRoute("admin_rule_group_view", [
            'id' => $entity->getId(),
        ]);
    }

    /**
     * New element action
     *
     * This action is just a wrapper, so should never get any data,
     * as this is component responsibility
     *
     * @param integer $id Entity id
     *
     * @return array Result
     *
     * @Route(
     *      path = "/{id}/edit",
     *      name = "admin_rule_group_edit"
     * )
     * @Template
     * @Method({"GET"})
     */
    public function editAction($id)
    {
        return [
            'id' => $id,
        ];
    }

    /**
     * New element component action
     *
     * As a component, this action should not return all the html macro, but
     * only the specific component
     *
     * @param RuleGroupInterface $entity   Entity
     * @param FormView           $formView Form view
     *
     * @return array Result
     *
     * @Route(
     *      path = "/{id}/edit/component",
     *      name = "admin_rule_group_edit_component"
     * )
     * @Template("AdminRuleBundle:RuleGroup:Component/editComponent.html.twig")
     * @Method({"GET"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.core.rule.entity.rule_group.class",
     *      mapping = {
     *          "id": "~id~",
     *      }
     * )
     * @FormAnnotation(
     *      class = "elcodi_admin_rule_form_type_rule_group",
     *      name  = "formView",
     *      entity = "entity"
     * )
     */
    public function editComponentAction(
        RuleGroupInterface $entity,
        FormView $formView
    )
    {
        return [
            'entity' => $entity,
            'form'   => $formView,
        ];
    }

    /**
     * Updated edited element action
     *
     * Should be POST
     *
     * @param RuleGroupInterface $entity  Entity to update
     * @param FormInterface      $form    Form view
     * @param boolean            $isValid Request handle is valid
     *
     * @return RedirectResponse Redirect response
     *
     * @Route(
     *      path = "/{id}/update",
     *      name = "admin_rule_group_update"
     * )
     * @Method({"POST"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.core.rule.entity.rule_group.class",
     *      mapping = {
     *          "id": "~id~",
     *      }
     * )
     * @FormAnnotation(
     *      class = "elcodi_admin_rule_form_type_rule_group",
     *      name  = "form",
     *      entity = "entity",
     *      handleRequest = true,
     *      validate = "isValid"
     * )
     */
    public function updateAction(
        RuleGroupInterface $entity,
        FormInterface $form,
        $isValid
    )
    {
        if ($isValid) {
            $this
                ->get('elcodi.object_manager.rule_group')
                ->flush($entity);
        }

        return $this->redirectRoute("admin_rule_group_view", [
            'id' => $entity->getId(),
        ]);
    }

    /**
     * Enable entity
     *
     * @param Request          $request Request
     * @param EnabledInterface $entity  Entity to enable
     *
     * @return array Result
     *
     * @Route(
     *      path = "/{id}/enable",
     *      name = "admin_rule_group_enable"
     * )
     * @Method({"POST"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.core.rule.entity.rule_group.class",
     *      mapping = {
     *          "id" = "~id~"
     *      }
     * )
     * @JsonResponse
     */
    public function enableAction(
        Request $request,
        EnabledInterface $entity
    )
    {
        try {
            $this->enableEntity($entity);

            return [
                'result' => 'ok',
            ];
        } catch (Exception $e) {
            return [
                'result'  => 'ko',
                'code'    => $e->getCode(),
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Disable entity
     *
     * @param Request          $request Request
     * @param EnabledInterface $entity  Entity to disable
     *
     * @return array Result
     *
     * @Route(
     *      path = "/{id}/disable",
     *      name = "admin_rule_group_disable"
     * )
     * @Method({"POST"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.core.rule.entity.rule_group.class",
     *      mapping = {
     *          "id" = "~id~"
     *      }
     * )
     * @JsonResponse
     */
    public function disableAction(
        Request $request,
        EnabledInterface $entity
    )
    {
        try {
            $this->disableEntity($entity);

            return [
                'result' => 'ok',
            ];
        } catch (Exception $e) {
            return [
                'result'  => 'ko',
                'code'    => $e->getCode(),
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Delete entity
     *
     * @param Request $request     Request
     * @param mixed   $entity      Entity to delete
     * @param string  $redirectUrl Redirect url
     *
     * @return RedirectResponse Redirect response
     *
     * @Route(
     *      path = "/{id}/delete",
     *      name = "admin_rule_group_delete"
     * )
     * @Method({"GET"})
     *
     * @EntityAnnotation(
     *      class = "elcodi.core.rule.entity.rule_group.class",
     *      mapping = {
     *          "id" = "~id~"
     *      }
     * )
     * @JsonResponse
     */
    public function deleteAction(
        Request $request,
        $entity,
        $redirectUrl = null
    )
    {
        try {
            $this->deleteEntity($entity);

            return [
                'result' => 'ok',
            ];
        } catch (Exception $e) {
            return [
                'result'  => 'ko',
                'code'    => $e->getCode(),
                'message' => $e->getMessage(),
            ];
        }
    }
}

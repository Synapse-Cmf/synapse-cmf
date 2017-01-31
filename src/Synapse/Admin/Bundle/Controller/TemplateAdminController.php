<?php

namespace Synapse\Admin\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Synapse\Cmf\Bundle\Form\Type\Theme\TemplateType;
use Synapse\Cmf\Framework\Theme\Template\Model\TemplateInterface;
use Synapse\Cmf\Framework\Theme\Theme\Model\ThemeInterface;

/**
 * Controller for template management use cases action.
 */
class TemplateAdminController extends Controller
{
    /**
     * Templates listing action.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function listAction(Request $request)
    {
        $theme = $request->attributes->get(
            'synapse_theme',
            $this->container->get('synapse')
                ->enableDefaultTheme()
                ->getCurrentTheme()
        );

        $templateCollection = $this->container->get('synapse.template.loader')
            ->retrieveAll(array('scope' => TemplateInterface::GLOBAL_SCOPE))
        ;
        $templateMap = array();
        foreach ($templateCollection as $template) {
            $templateMap[$template->getTemplateType()->getName()][$template->getContentType()->getName()] = $template;
        }

        return $this->render('SynapseAdminBundle:Template:list.html.twig', array(
            'theme' => $theme,
            'content_types' => $this->container->get('synapse.content_type.loader')
                ->retrieveAll(),
            'templates' => $templateMap,
        ));
    }

    /**
     * Template init action.
     *
     * @param Request $request
     * @param string  $templateType
     * @param string  $contentType
     * @param int     $contentId
     *
     * @return Response
     */
    public function initAction(Request $request, $templateType, $contentType, $contentId = null)
    {
        $templateDomain = $this->container->get('synapse.template.domain');

        $template = empty($contentId)
            ? $templateDomain->createGlobal(
                $contentType,
                $templateType
            )
            : $templateDomain->createLocal(
                $this->container->get('synapse.content.resolver')->resolveContentId($contentType, $contentId),
                $templateType
            )
        ;

        return new RedirectResponse(empty($contentId)
            ? $this->container->get('router')->generate('synapse_admin_template_edition', array(
                'id' => $template->getId(),
            ))
            : $request->server->get('HTTP_REFERER')
        );
    }

    /**
     * Global template edition action.
     * Requires an activated or activable theme.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function editAction($id, Request $request)
    {
        $template = $this->container->get('synapse.template.orm_loader')
            ->retrieveOne(array(
                'id' => $id,
                'scope' => TemplateInterface::GLOBAL_SCOPE
            ))
        ;
        if (!$template) {
            throw new NotFoundHttpException(sprintf('No global template found for id "%s"', $id));
        }

        $form = $this->container->get('form.factory')->createNamed(
            'template',
            TemplateType::class,
            $template,
            array(
                'theme' => $request->attributes->get(
                    'synapse_theme',
                    $this->container->get('synapse')
                        ->enableDefaultTheme()
                        ->getCurrentTheme()
                ),
                'content_type' => $template->getContentType(),
                'template_type' => $template->getTemplateType(),
                'action' => $formUrl = $this->container->get('router')->generate(
                    'synapse_admin_template_edition',
                    array('id' => $template->getId())
                ),
                'method' => 'POST',
                'csrf_protection' => false,
            )
        );
        if ($request->request->has('template')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                return $this->redirect(
                    $this->container->get('router')->generate(
                        'synapse_admin_template_edition',
                        array('id' => $template->getId())
                    )
                );
            }
        }

        return $this->render('SynapseAdminBundle:Template:edit.html.twig', array(
            'template' => $template,
            'form' => $form->createView(),
        ));
    }

    /**
     * Adds a component of given type id into given template id and zone type id.
     *
     * @param int     $id
     * @param string  $zoneTypeId
     * @param string  $componentTypeId
     * @param Request $request
     *
     * @return Response
     */
    public function addComponentAction($id, $zoneTypeId, $componentTypeId, Request $request)
    {
        if (!$template = $this->container->get('synapse.template.loader')->retrieve($id)) {
            throw new NotFoundHttpException(sprintf('No template found under id "%s"', $id));
        }
        if (!$zoneType = $template->getTemplateType()
            ->getZoneTypes()
            ->search(array('id' => $zoneTypeId))
            ->first()
        ) {
            throw new NotFoundHttpException(sprintf(
                'Zone type "%s" is not activated for template "%s". Please check theme configuration.',
                $zoneTypeId,
                $templateType->getId()
            ));
        }
        if (!$componentType = $this->container->get('synapse.component_type.loader')->retrieve($componentTypeId)) {
            throw new NotFoundHttpException(sprintf(
                'No defined component type found under id "%s". Please check theme configuration.',
                $componentTypeId
            ));
        }

        $this->container->get('synapse.zone.domain')->addComponent(
            $template->getZones()->search(array('zoneType' => $zoneType))->first(),
            $componentType
        );

        return new RedirectResponse(
            $request->server->get('HTTP_REFERER')
        );
    }
}

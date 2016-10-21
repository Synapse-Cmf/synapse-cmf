<?php

namespace Synapse\Admin\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Synapse\Cmf\Bundle\Form\Type\Theme\TemplateType;
use Synapse\Cmf\Framework\Theme\Template\Model\TemplateInterface;

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
        $templateCollection = $this->container->get('synapse.template.loader')->retrieveAll(array(
            'scope' => TemplateInterface::GLOBAL_SCOPE,
        ));
        $templateMap = array();
        foreach ($templateCollection as $template) {
            $templateMap[$template->getTemplateType()->getName()][$template->getContentType()->getName()] = $template;
        }

        return $this->render('SynapseAdminBundle:Template:list.html.twig', array(
            'theme' => $this->container->get('synapse.theme.loader')->retrieve(
                $request->attributes->get('synapse_theme')
            ),
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
     * @param Request $request
     *
     * @return Response
     */
    public function editAction($id, Request $request)
    {
        $form = $this->container->get('form.factory')->createNamed(
            'template',
            TemplateType::class,
            $template = $this->container->get('synapse.template.loader')
                ->retrieveAll(array('id' => $id, 'scope' => TemplateInterface::GLOBAL_SCOPE))
                ->first(),
            array(
                'theme' => $this->container->get('synapse.theme.loader')->retrieve(
                    $request->attributes->get('synapse_theme')
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
}

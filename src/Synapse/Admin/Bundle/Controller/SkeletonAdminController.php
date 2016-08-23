<?php

namespace Synapse\Admin\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Synapse\Cmf\Bundle\Form\Type\Framework\Template\EditionType;
use Synapse\Cmf\Bundle\Form\Type\Framework\Template\GlobalCreationType;
use Synapse\Cmf\Framework\Theme\Template\Model\TemplateInterface;

/**
 * Controller class which handle skeleton use cases.
 */
class SkeletonAdminController extends Controller
{
    /**
     * Skeletons listing action.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function listAction(Request $request)
    {
        return $this->render('SynapseAdminBundle:Skeleton:list.html.twig', array(
            'skeletons' => $this->container->get('synapse.template.loader')->retrieveAll(array(
                'scope' => TemplateInterface::GLOBAL_SCOPE,
            )),
        ));
    }

    /**
     * Skeleton initialization action.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function initAction(Request $request)
    {
        $form = $this->container->get('form.factory')->createNamed(
            'skeleton',
            GlobalCreationType::class,
            null,
            array(
                'action' => $this->container->get('router')->generate('synapse_admin_skeleton_init'),
                'method' => 'POST',
                'csrf_protection' => false,
            )
        );
        if ($request->request->has('skeleton')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                return $this->redirect(
                    $this->container->get('router')->generate(
                        'synapse_admin_skeleton_edition',
                        array('id' => $form->getData()->getId())
                    )
                );
            }
        }

        return $this->render('SynapseAdminBundle:Skeleton:create.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function editAction($id, Request $request)
    {
        $form = $this->container->get('form.factory')->createNamed(
            'skeleton',
            EditionType::class,
            $template = $this->container->get('synapse.template.loader')
                ->retrieveAll(array('id' => $id, 'scope' => TemplateInterface::GLOBAL_SCOPE))
                ->first(),
            array(
                'theme' => $this->container->get('synapse.theme.loader')->retrieve(
                    $request->attributes->get('synapse_theme')
                ),
                'content_type' => $template->getContentType(),
                'action' => $formUrl = $this->container->get('router')->generate(
                    'synapse_admin_skeleton_edition',
                    array('id' => $template->getId())
                ),
                'method' => 'POST',
                'csrf_protection' => false,
            )
        );
        if ($request->request->has('skeleton')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                return $this->redirect(
                    $this->container->get('router')->generate(
                        'synapse_admin_skeleton_edition',
                        array('id' => $template->getId())
                    )
                );
            }
        }

        return $this->render('SynapseAdminBundle:Skeleton:edit.html.twig', array(
            'skeleton' => $template,
            'form' => $form->createView(),
        ));
    }
}

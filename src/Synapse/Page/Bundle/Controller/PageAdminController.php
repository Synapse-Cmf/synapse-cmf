<?php

namespace Synapse\Page\Bundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Synapse\Page\Bundle\Entity\Page;
use Synapse\Page\Bundle\Form\Page\CreationType;
use Synapse\Page\Bundle\Form\Page\EditionType;

/**
 * Controller class for Page administration actions.
 */
class PageAdminController extends Controller implements ParamConverterInterface
{
    /**
     * @see ParamConverterInterface::supports()
     */
    public function supports(ParamConverter $configuration)
    {
        return $configuration->getClass() == Page::class;
    }

    /**
     * @see ParamConverterInterface::apply()
     */
    public function apply(Request $request, ParamConverter $configuration)
    {
        if (!$page = $this->container->get('synapse.page.loader')
            ->retrieve($pageId = $request->attributes->get('id'))
        ) {
            throw new NotFoundHttpException(sprintf('Page#%d not found.', $pageId));
        }

        $request->attributes->set(
            $configuration->getName(),
            $page
        );

        return true;
    }

    /**
     * Page list action.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function listAction(Request $request)
    {
        return $this->render('SynapsePageBundle:Admin/Page:list.html.twig', array(
            'pages' => $this->container->get('synapse.page.loader')->retrieveAll(),
            'page_rendering_route' => $this->container->getParameter('synapse.page.rendering_route'),
        ));
    }

    /**
     * Page creation action.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function createAction(Request $request)
    {
        $form = $this->container->get('form.factory')->createNamed(
            'page',
            CreationType::class,
            null,
            array(
                'action' => $this->container->get('router')->generate('synapse_admin_page_creation'),
                'method' => 'POST',
                'csrf_protection' => false,
            )
        );

        if ($request->request->has('page')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $page = $form->getData();

                return $this->redirect(
                    $this->container->get('router')->generate('synapse_admin_page_edition', array(
                        'id' => $page->getId(),
                    ))
                );
            }
        }

        return $this->render('SynapsePageBundle:Admin/Page:create.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Page creation action.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function editAction(Page $page, Request $request)
    {
        $form = $this->container->get('form.factory')->createNamed(
            'page',
            EditionType::class,
            $page,
            array(
                'action' => $this->container->get('router')->generate(
                    'synapse_admin_page_edition',
                    array('id' => $page->getId())
                ),
                'synapse_theme' => $request->get('synapse_theme'),
                'method' => 'POST',
                'csrf_protection' => false,
            )
        );

        if ($request->request->has('page')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                return $this->redirect(// refresh to rebuild dynamic form
                    $this->container->get('router')->generate(
                        $request->attributes->get('_route'),
                        $request->attributes->get('_route_params')
                    )
                );
            }
        }

        return $this->render('SynapsePageBundle:Admin/Page:edit.html.twig', array(
            'form' => $form->createView(),
            'page' => $page,
        ));
    }
}

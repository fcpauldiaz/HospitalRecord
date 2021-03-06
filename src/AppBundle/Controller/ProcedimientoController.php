<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Procedimiento;
use AppBundle\Form\Type\ProcedimientoType;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Procedimiento controller.
 *
 * @Route("/procedimiento")
 */
class ProcedimientoController extends Controller
{
    /**
     * Lists all Procedimiento entities.
     *
     * @Route("/", name="procedimiento")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('AppBundle:Procedimiento')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Procedimiento entity.
     *
     * @Route("/", name="procedimiento_create")
     * @Method("POST")
     * @Template("AppBundle:Procedimiento:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Procedimiento();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('braincrafted_bootstrap.flash')->success(
                sprintf('Se ha creado el procedimiento %s correctamente', $entity->getDescripcionProcedimiento()
                ));
            $em = $this->getDoctrine()->getManager();

            $entities = $em->getRepository('AppBundle:Procedimiento')->findAll();
            foreach ($entities as $entity) {
                $key[] = array(
                    'key' => $entity->getDescripcionProcedimiento(),
                    // other fields
                );
                $value[] = array(
                    'value' => $entity->getId(),
                    // other fields
                );
            }

            return new JsonResponse(([$key, $value]));
        }

        return new JsonResponse(['error' => $form->getErrorsAsString()], 400);
    }

    /**
     * Creates a form to create a Procedimiento entity.
     *
     * @param Procedimiento $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Procedimiento $entity)
    {
        $form = $this->createForm(new ProcedimientoType(), $entity, array(
            'action' => $this->generateUrl('procedimiento_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Guardar',
            'attr' => [
                    'class' => 'btn btn-primary',
                ],
            ));

        return $form;
    }

    /**
     * Displays a form to create a new Procedimiento entity.
     *
     * @Route("/new", name="procedimiento_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Procedimiento();
        $form = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Procedimiento entity.
     *
     * @Route("/{id}", name="procedimiento_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Procedimiento')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Procedimiento entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Procedimiento entity.
     *
     * @Route("/{id}/edit", name="procedimiento_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Procedimiento')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Procedimiento entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Creates a form to edit a Procedimiento entity.
     *
     * @param Procedimiento $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Procedimiento $entity)
    {
        $form = $this->createForm(new ProcedimientoType(), $entity, array(
            'action' => $this->generateUrl('procedimiento_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Procedimiento entity.
     *
     * @Route("/{id}", name="procedimiento_update")
     * @Method("PUT")
     * @Template("AppBundle:Procedimiento:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AppBundle:Procedimiento')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Procedimiento entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('procedimiento_edit', array('id' => $id)));
        }

        return array(
            'entity' => $entity,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Procedimiento entity.
     *
     * @Route("/{id}", name="procedimiento_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AppBundle:Procedimiento')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Procedimiento entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('procedimiento'));
    }

    /**
     * Creates a form to delete a Procedimiento entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('procedimiento_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}

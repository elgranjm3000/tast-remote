<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Taskboard;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\HttpFoundation\JsonResponse;



class TaskboardController extends Controller
{



    /**
     * @Route("/taskboard", name="taskboard")
     */
    public function index(Request $request)
    {

		$repository = $this->getDoctrine()->getRepository(Taskboard::class);
		$tareas = $repository->findAll();

$task = new Taskboard();
        $task->setTitulo('');
        $task->setDescripcion('');
        $task->setFechacreacion(new \DateTime('tomorrow'));
        $task->setFechacomienzo(new \DateTime('tomorrow'));
        $task->setFechafin(new \DateTime('tomorrow'));        

        $form = $this->createFormBuilder($task)
            ->add('titulo', TextType::class)
            ->add('descripcion', TextType::class)
            ->add('fechacreacion', DateTimeType::class, array('widget' => 'single_text'))
            ->add('fechacomienzo', DateTimeType::class, array('widget' => 'single_text'))
            ->add('fechafin', DateTimeType::class, array('widget' => 'single_text'))
            ->getForm();

$form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // $form->getData() holds the submitted values
        // but, the original `$task` variable has also been updated
        $task = $form->getData();

        // ... perform some action, such as saving the task to the database
        // for example, if Task is a Doctrine entity, save it!
         $entityManager = $this->getDoctrine()->getManager();
         
         $task->setUserid(1);
         
         $entityManager->persist($task);
         $entityManager->flush();


        $generardatos = array();
        $localidad['titulo'] =   $task->getTitulo();        
        $localidad['descripcion'] =   $task->getDescripcion();
        $localidad['id'] =   $task->getId();
        $generardatos[] = $localidad;
        return new JsonResponse($generardatos);


            //return $this->redirect($this->generateUrl('taskboard', array()));

     //   return $this->redirectToRoute('task_success');
    }



        return $this->render('taskboard/index.html.twig', [
            'controller_name' => 'TaskboardController','tareas'=>$tareas,'form' => $form->createView()
        ]);
    }
}

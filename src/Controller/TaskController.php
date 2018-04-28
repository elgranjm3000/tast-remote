<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Task;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;


class TaskController extends Controller
{




/**
     * @Route("/status", name="cambiarstatus")
     */
    public function status(Request $request)
    {
    	$id = $_GET['id'];
    	$status = $_GET['status'];
  		$entityManager = $this->getDoctrine()->getManager();
    	$product = $entityManager->getRepository(Task::class)->find($id);
    	$product->setEstado($status);
    	$entityManager->flush();
    	exit;
    }




/**
     * @Route("/progresotask", name="progreso")
     */
    public function progreso(Request $request)
    {
    	$valor = $_GET['valor'];
    	$repository = $this->getDoctrine()->getRepository(Task::class);
		$tareas = $repository->findBy(['estado' => $valor]);

		 return $this->render('task/progreso.html.twig', ['tareas'=>$tareas
        ]);

    }

    /**
     * @Route("/task", name="task")
     */
    public function index(Request $request)
    {

		$repository = $this->getDoctrine()->getRepository(Task::class);
		$tareas = $repository->findAll();



    	$task = new Task();
        $task->setTitulo('');
        $task->setDescripcion('');
        $task->setEstado('');
        $task->setFechacreacion(new \DateTime('tomorrow'));
        $task->setFechacomienzo(new \DateTime('tomorrow'));
        $task->setFechafin(new \DateTime('tomorrow'));        

        $form = $this->createFormBuilder($task)
            ->add('titulo', TextType::class)
            ->add('estado', TextType::class)
            ->add('descripcion', TextType::class)
            ->add('fechacreacion', DateTimeType::class, array('widget' => 'single_text'))
            ->add('fechacomienzo', DateTimeType::class, array('widget' => 'single_text'))
            ->add('fechafin', DateTimeType::class, array('widget' => 'single_text'))
            ->add('estado', HiddenType::class)
            ->getForm();

$form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // $form->getData() holds the submitted values
        // but, the original `$task` variable has also been updated
        $task = $form->getData();

        // ... perform some action, such as saving the task to the database
        // for example, if Task is a Doctrine entity, save it!
         $entityManager = $this->getDoctrine()->getManager();
         $task->setTiempo("0");
         $task->setIduser(1);
         $task->setIdfile(1);
         $entityManager->persist($task);
         $entityManager->flush();
            return $this->redirect($this->generateUrl('task', array()));

     //   return $this->redirectToRoute('task_success');
    }
        return $this->render('task/list.html.twig', [
            'controller_name' => 'TaskController', 'form' => $form->createView(),'tareas'=>$tareas
        ]);
    }
}

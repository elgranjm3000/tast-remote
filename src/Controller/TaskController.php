<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Task;
use App\Entity\Taskboard;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\HttpFoundation\JsonResponse;


class TaskController extends Controller
{




    /**
     * @Route("/modificartask", name="modificartask")
     */
    public function modificartask(Request $request)
    {

       $descripcion = $_GET['descripcion'];
       $nota = $_GET['nota'];
       $id = $_GET['id'];
      
        $entityManager = $this->getDoctrine()->getManager();
        $tareas = $entityManager->getRepository(Task::class)->find($id);
        
        if($descripcion){
            $tareas->setTitulo($descripcion);
        }
      if($nota){
        $tareas->setDescripcion($nota);
      }

        $entityManager->flush();
        
        exit;
    }


    /**
     * @Route("/deletereporte", name="deletereporte")
     */
    public function deletereporte(Request $request)
    {

       $id = $_GET['id'];        
      
        $entityManager = $this->getDoctrine()->getManager();
        $tareas = $entityManager->getRepository(Task::class)->find($id);
       $entityManager->remove($tareas);
        $entityManager->flush();
        
        exit;
    }


    /**
     * @Route("/task/agregar/{id}", name="agregar")
     */
    public function agregar(Request $request,$id)
    {
      
        $entityManager = $this->getDoctrine()->getManager();
        $tareas = $entityManager->getRepository(Task::class)->find($id);
       
        return $this->render('task/agregar.html.twig', ['entity'=>$tareas
        ]);

    }
          



 /**
     * @Route("/", name="home")
     */
    public function home()
    {
        return $this->redirect($this->generateUrl('taskboard'));
    }

    /**
     * @Route("/guardatiempo", name="guardatiempo")
     */
    public function tiempo(Request $request)
    {
       
        $hoy = date("Y-m-d H:i:s");           
        $id = $_POST['reporte'];        
        $entityManager = $this->getDoctrine()->getManager();
        $product = $entityManager->getRepository(Task::class)->find($id);

        if($product->getStatus() == ''){
                $product->setTiempo($hoy);
                $product->setStatus("I");
        }
                $entityManager->flush();


            exit;
    }


        /**
     * @Route("/pausatiempo", name="pausatiempo")
     */
    public function pausatiempo(Request $request)
    {
       
            
        $id = $_POST['reporte'];        
        $tiempo = $_POST['tiempo'];        
        $entityManager = $this->getDoctrine()->getManager();
        $product = $entityManager->getRepository(Task::class)->find($id);
        $product->setTiempo($tiempo);
        $product->setStatus("P");        
        $entityManager->flush();


            exit;
    }



/**
     * @Route("/taskboardbuscar", name="taskboardbuscar")
     */
    public function buscar(Request $request)
    {
        $id = $_POST['idtask'];
        $repository = $this->getDoctrine()->getRepository(Task::class);
        $tareas = $repository->find($id);
        $generardatos = array();
        $localidad['fechacreacion'] =   $tareas->getFechacreacion();
        $localidad['tiempo'] =   $tareas->getTiempo();
        $localidad['actual'] =   date("Y-m-d H:i:s");   
        $localidad['status'] =   $tareas->getStatus();
         $generardatos[] = $localidad;
        return new JsonResponse($generardatos);

    }

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
    	$idtaskboard = $_GET['idtaskboard'];
    	$repository = $this->getDoctrine()->getRepository(Task::class);
		$tareas = $repository->findBy(['estado' => $valor,'idtaskboad'=>$idtaskboard]);

		 return $this->render('task/progreso.html.twig', ['tareas'=>$tareas
        ]);

    }

    /**
     * @Route("/task/{id}", name="task")
     */
    public function index(Request $request,$id)
    {

		$repository = $this->getDoctrine()->getRepository(Task::class);
		$tareas = $repository->findBy(['idtaskboad'=>$id]);




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
        $ip=$this->getDoctrine()->getEntityManager();  

        // ... perform some action, such as saving the task to the database
        // for example, if Task is a Doctrine entity, save it!
         $entityManager = $this->getDoctrine()->getManager();
         $task->setTiempo("0");
         $task->setIduser(1);
         $task->setTaskboard($ip->getReference(Taskboard::class,$id));
         $entityManager->persist($task);
         $entityManager->flush();
//            return $this->redirect($this->generateUrl('task', array('id'=>$id)));

  return $this->redirect($this->generateUrl('agregar', array('id'=>$task->getId())));

     //   return $this->redirectToRoute('task_success');
    }
        return $this->render('task/list.html.twig', [
            'controller_name' => 'TaskController', 'form' => $form->createView(),'tareas'=>$tareas,'idtask' => $id
        ]);
    }
}

<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Task;
use App\Entity\Files;
use App\Entity\Taskboard;
use App\Entity\Usuarios;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class TaskController extends Controller
{




/**
     * @Route("/files/delete", name="deletefile")
     */
public function filesdelete(Request $request)
{


       $entityManager = $this->getDoctrine()->getManager();
$files = $entityManager->getRepository(Files::class)->find($_GET['id']);
         $entityManager->remove($files);
        $entityManager->flush();
        exit;

}



/**
     * @Route("/files", name="listadoarchivo")
     */
public function filesindex(Request $request)
{


       $entityManager = $this->getDoctrine()->getManager();
$files = $entityManager->getRepository(Files::class)->findBy(['idtask' => $_GET['id']]);
       
        return $this->render('task/indexfiles.html.twig', ['entity'=>$files
        ]);

}

/**
     * @Route("/listarchivo/{id}", name="listarchivo")
     */
public function fileslist(Request $request,$id)
{


       $entityManager = $this->getDoctrine()->getManager();
        $files = $entityManager->getRepository(Files::class)->find($id);
       
        return $this->render('task/files.html.twig', ['entity'=>$files
        ]);

}

  /**
     * @Route("/filestask", name="filestask")
     */
public function filestask(Request $request)
    {

if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
{
 $uploads_dir = 'uploads';

    //obtenemos el archivo a subir
    $file = $_FILES['archivo']['tmp_name'];
    $name = $_FILES['archivo']['name'];
    $size = $_FILES['archivo']['size'];
    $type = $_FILES['archivo']['type'];

        $namemove = basename($name);


  move_uploaded_file($file, "$uploads_dir/$namemove");


        $ip=$this->getDoctrine()->getEntityManager();  

        $archivos = new Files();
        $archivos->setFiles($file);
        $archivos->setName($name);
        $archivos->setExt($type);
        $archivos->setSize($size);
        $archivos->setTask($ip->getReference(Task::class,$_POST['idtask']));
        $entityManager = $this->getDoctrine()->getManager();        
        $entityManager->persist($archivos);
        $entityManager->flush();

  return $this->redirect($this->generateUrl('listarchivo', array('id'=>$archivos->getId())));
 
 
}else{
    throw new Exception("Error Processing Request", 1);   
}


exit;

    }




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


        $generardatos = array();

        $localidad['minotas'] =   strip_tags($tareas->getDescripcion());
        
         $generardatos[] = $localidad;
        return new JsonResponse($generardatos);
        
        
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

       // if($product->getStatus() == ''){
                $product->setTiempo($hoy);
                $product->setStatus("I");
     //   }
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
        $localidad['fechainicio'] =   date_format($tareas->getFechacomienzo(),'d/m/Y h:i:s');
        $localidad['fechafin'] = date_format($tareas->getFechafin(),'d/m/Y h:i:s');
        $localidad['tiempo'] =   $tareas->getTiempo();
        $localidad['actual'] =   date("Y-m-d H:i:s");   
        $localidad['status'] =   $tareas->getStatus();
        $localidad['descripcion'] =   $tareas->getDescripcion();
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
            ->add('descripcion', TextareaType::class, array(
    'attr' => array('class' => 'add_product_desc'),
))
            ->add('fechacreacion', DateTimeType::class, array('date_widget' => 'single_text', 'time_widget' => 'single_text'))
            ->add('fechacomienzo', DateTimeType::class, array('date_widget' => 'single_text', 'time_widget' => 'single_text'))
            ->add('fechafin', DateTimeType::class, array('date_widget' => 'single_text', 'time_widget' => 'single_text'))
            ->add('estado', HiddenType::class)
            ->add('usuarios', EntityType::class, array(
    'class' => Usuarios::class,
     'multiple' => true,
        'choice_label' => 'usuario',
))
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
            'controller_name' => 'TaskController', 'form' => $form->createView() ,'tareas'=>$tareas,'idtask' => $id
        ]);
    }



 /**
     * @Route("/fechamodificar", name="fechamodificar")
     */
    public function fechamodificar(Request $request)
    {

       //$fecha = $_GET['inicio'];

          $fecha = new \DateTime($_GET['inicio']);
       $tipo = $_GET['tipo'];
       $id = $_GET['id'];
      
        $entityManager = $this->getDoctrine()->getManager();
        $tareas = $entityManager->getRepository(Task::class)->find($id);
        
        if($tipo == "I"){
            $tareas->setFechacomienzo($fecha);
            $entityManager->flush();
        }
         if($tipo == "F"){
            $tareas->setFechafin($fecha);
            $entityManager->flush();
        }

        


        $generardatos = array();

        $localidad['minotas'] =   strip_tags($tareas->getDescripcion());
        
         $generardatos[] = $localidad;
        return new JsonResponse($generardatos);
        
        
    }

}

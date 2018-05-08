<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Usuarios;
use App\Entity\Task;

class UsuariosController extends Controller
{
    /**
     * @Route("/usuarios", name="usuarios")
     */
    public function index()
    {
        return $this->render('usuarios/index.html.twig', [
            'controller_name' => 'UsuariosController',
        ]);
    }


    /**
     * @Route("/usuarioslistado", name="usuarioslistado")
     */
    public function usuarioslistado()
    {

    	$id = $_GET['id'];



       $entityManager = $this->getDoctrine()->getManager();
$usuarios = $entityManager->getRepository(Task::class)->find($id);

        return $this->render('usuarios/listado.html.twig', [
            'entity' => $usuarios,
        ]);
    }


    

}

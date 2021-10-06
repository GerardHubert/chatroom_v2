<?php

namespace App\Controller;

use App\Form\LoginFormType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home()
    {
        $form = $this->createForm(LoginFormType::class);

        return $this->render('home.html.twig', [
            "formview" => $form->createView()
        ]);
    }
}

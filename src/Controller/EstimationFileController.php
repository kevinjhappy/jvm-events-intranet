<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EstimationFileController extends AbstractController
{
    /**
     * @Route("/estimation/file", name="estimation_file")
     */
    public function index()
    {
        return $this->render('estimation_file/index.html.twig', [
            'controller_name' => 'EstimationFileController',
        ]);
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main_home")
     */
    public function home(): \Symfony\Component\HttpFoundation\Response
    {
        return $this->render('main/home.html.twig');
    }

    /**
     * @Route("/about-us", name="main_about_us")
     */
    public function about(): \Symfony\Component\HttpFoundation\Response
    {
        $rawData = file_get_contents("../data/team.json");
        $teamMembers = json_decode($rawData, true);
        return $this->render('main/about_us.html.twig', ['teamMembers' => $teamMembers]);
    }

}
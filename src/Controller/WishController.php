<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\WishType;
use App\Repository\WishRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WishController extends AbstractController
{
    /**
     * @Route("/wishes", name="wish_list")
     */
    public function list(WishRepository $wishRepository): Response
    {
        $wishes = $wishRepository->findBy(['isPublished' => true], ['dateCreated' => 'DESC']);
        return $this->render('wish/list.html.twig', [
            "wishes" => $wishes
        ]);
    }


    /**
     * @Route("/wishes/detail/{id}", name="wish_detail")
     */
    public function detail(int $id, WishRepository $wishRepository): Response
    {
        $wish = $wishRepository->find($id);

        return $this->render('wish/detail.html.twig', [
            "wish" => $wish
        ]);
    }

    /**
     * @Route("/wishes/create", name="wish_create")
     */
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $wish = new Wish();
        $wishForm = $this->createForm(WishType::class, $wish);
        $wishForm->handleRequest($request);

        if ($wishForm->isSubmitted() && $wishForm->isValid()){
            $wish->setIsPublished(true);
            $wish->setDateCreated(new \DateTime());
            $entityManager->persist($wish);
            $entityManager->flush();
            $this->addFlash('success', 'Idea successfully added!');
            return $this->redirectToRoute('wish_detail', ['id' => $wish->getId()]);
        }
        return $this->render('wish/create.html.twig', [
            'wishForm' => $wishForm->createView()
        ]);
    }
}

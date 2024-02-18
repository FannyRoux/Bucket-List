<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Wish;
use App\Form\WishType;
use App\Repository\WishRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
#[Route ('/wish', name:'wish_')]
class WishController extends AbstractController
{
    #[Route('/wishList', name: 'list')]
    public function wishlist(WishRepository $wishRepository): Response
    {
        $wishes = $wishRepository->findBy(['isPublished'=>true],['dateCreated'=>'DESC']);
        return $this->render('wish/wishList.html.twig',[
            'wishes'=>$wishes
        ]);
    }

    #[Route('/wishDetails/{id}', name:'details')]
    public function whishDetails(int $id, WishRepository $wishRepository):Response
    {
        $wish= $wishRepository->find($id);
        return $this->render('wish/wishDetails.html.twig',[
            'wish'=>$wish
        ]);
    }

    #[Route('/newWish', name:'new')]
    public function addWish(EntityManagerInterface $entityManager, Request $request):Response
    {
        $newWish = new Wish();
        $newWish->setDateCreated(new DateTime());
        $newWish->setIsPublished(true);
        $currentUser = $this->getUser()->getUserIdentifier();
        $newWish->setAuthor($currentUser);
        $newWishForm = $this->createForm(WishType::class,$newWish);

        $newWishForm->handleRequest($request);
        if($newWishForm->isSubmitted() && $newWishForm->isValid()){
            $entityManager->persist($newWish);
            $entityManager->flush();

            $this->addFlash('success','New wish created !');
            return $this->redirectToRoute('wish_details', ['id'=> $newWish->getId()]);
        }
        return $this->render('wish/newWish.html.twig', [
            'newWishForm'=>$newWishForm->createView()
        ]);
    }
}

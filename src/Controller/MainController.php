<?php

namespace App\Controller;

use App\Entity\Users;
use App\Entity\Quotes;
use App\Form\CRUDType;
use App\Form\QuotesCRUDType;
use App\Repository\UsersRepository;
use App\Repository\MoviesRepository;
use App\Repository\QuotesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class MainController extends AbstractController
{
    /**
     * @Route("/home", name="app_home")
     */
    public function index(): Response
    {
        return $this->render('home/home.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
    /**
     * @Route("/characters", name="app_characters")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function allusers(UsersRepository $repo): Response
    {
        $users = $repo->findAll();
        return $this->render('characters/Allcharacters.html.twig', [
            'controller_name' => 'MainController',
            'users'=> $users,
        ]);
    }
    /**
     * @Route("/character/{id}", name="app_character")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function finduser($id, UsersRepository $repo): Response
    {
        $user = $repo->find($id);
        $movies = $user->getMovies();
        $quotes = $user->getQuotes();
        return $this->render('characters/CharacterDetail.html.twig', [
            'controller_name' => 'MainController',
            'user'=> $user,
            'movies'=>$movies,
            'quotes'=>$quotes,
        ]);
    }    
    private function generateUniqueFilename() {
        return md5(uniqid()) . '.' . $this->get('request_stack')->getCurrentRequest()->getRequestFormat();
    }
    /**
     * @Route("/profile", name="app_profile")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function profile(Request $request, UsersRepository $Urepo, QuotesRepository $Qrepo ): Response
    {   
        $userID = $this->getUser()->getUserIdentifier();   
        $Udatas = $Urepo->findOneBy(['username' => $userID]);
        $form = $this->createForm(CRUDType::class, $Udatas);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
    
            // handle avatar upload
            $avatar = $form->get('avatar')->getData();
            if ($avatar) {
                $newFilename = $this->generateUniqueFilename() . '.' . $avatar->guessExtension();
                $avatar->move(
                    $this->getParameter('avatars_directory'),
                    $newFilename
                );
    
                $Udatas->setAvatar($newFilename);
            }
            

            $Urepo->add($Udatas, true);
            $this->addFlash('notice','Votre profil a bien été modifié');
            return $this->redirectToRoute("app_characters");

            
        }
        // $Qdatas = $Qrepo->findOneBy(['characters' => $Udatas->getId()]);
        // $Qform =  $this->createForm(QuotesCRUDType::class, $Qdatas);
        // $Qform->handleRequest($request);
        // if ($Qform->isSubmitted() && $Qform->isValid()) {

        //     $Qrepo->add($Qdatas, true);
        //     $this->addFlash('notice','Quote modifié');
        //     return $this->redirectToRoute("app_characters");
        // }

        $movies = $Udatas->getMovies();
        $quotes = $Udatas->getQuotes();

        return $this->render('security/profile.html.twig', [
            'controller_name' => 'MainController',
            'form' =>  $form->createView(),
            // 'quotesForm' =>  $Qform->createView(),
            'user' => $Udatas,
            'movies' => $movies,
            'quotes' => $quotes,
            
        ]);
    }
    
    /**
     * @Route("/edit/{id}", name="app_profile_admin")
     * @IsGranted("ROLE_ADMIN")
     */
    public function Edit(Request $request, UsersRepository $Urepo, $id ): Response
    {   
        
        $Udatas = $Urepo->find($id);
        $form = $this->createForm(CRUDType::class, $Udatas);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // handle avatar upload
            $avatar = $form->get('avatar')->getData();
            if ($avatar) {
                $newFilename = $this->generateUniqueFilename() . '.' . $avatar->guessExtension();
                $avatar->move(
                    $this->getParameter('avatars_directory'),
                    $newFilename
                );
    
                $Udatas->setAvatar($newFilename);
            }

            $Urepo->add($Udatas, true);
            $this->addFlash('notice','Votre profil a bien été modifié');
            return $this->redirectToRoute("app_characters");
        }
        $movies = $Udatas->getMovies();
        $quotes = $Udatas->getQuotes();

        return $this->render('security/profile.html.twig', [
            'controller_name' => 'MainController',
            'form' =>  $form->createView(),
            'user' => $Udatas,
            'movies' => $movies,
            'quotes' => $quotes,
            
        ]);
    }
    /**
     * @Route("/delete/{id}", name="app_delete", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete($id, UsersRepository $repo): Response
    { 
        $data = $repo -> find($id);
        $repo->remove($data,true);
        $this->addFlash('success','L\'utilisateur a bien été supprimé');
        return $this->redirectToRoute('app_characters');
    }

    /**
     * @Route("/gallery", name="app_gallery")
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function rienbis(): Response
    {
        return $this->render('gallery/gallery.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ArticleController extends AbstractController
{
    #[Route('/article', name: 'app_article')]
    public function addArticle(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $article->setCreatedAt(new \DateTimeImmutable());
            /** @var \Symfony\Component\HttpFoundation\File\UploadedFile $pictureFile */
            $pictureFile = $form->get('pictureFilename')->getData();
           
                 if ($pictureFile) {
            $originalFilename = pathinfo($pictureFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $slugger->slug($originalFilename);
            $filename = $safeFilename.'-'.uniqid().'.'.$pictureFile->guessExtension();
                try {
                    // À la manière de move_uploaded_file en PHP, on tente ici de déplacer le fichier
                    // de sa zone de transit à sa destination
                    // Cette méthode peut lancer des exceptions : on encadre donc l'appel par un bloc
                    // try...catch
                    $pictureFile->move(
                        'uploads/article/',
                        $filename
                    );
                    // Si on n'est pas passé dans le catch, alors on peut enregistrer le nom du fichier
                    // dans la propriété profilePicFilename de l'utilisateur
                    $article->setPictureFilename($filename);
                } catch (FileException $e) {
                    $form->addError(new FormError("Erreur lors de l'upload du fichier"));
                }

          
        }
            $em->persist($article);
            $em->flush();
            
            $this->addFlash('success', 'article added with success');

           return $this->redirectToRoute('app_index');
        }

            return $this->render('article/article.html.twig', [
                'add_article' => $form,
            ]);
        
    }
}
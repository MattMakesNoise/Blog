<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Post;

final class BlogController extends AbstractController
{
    #[Route('/', name: 'blog_index')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $posts = $entityManager->getRepository(Post::class)->findBy([], ['createdAt' => 'DESC']);

        return $this->render('blog/index.html.twig', [
            'posts' => $posts, // Pass posts to template
        ]);
    }

    #[Route('/blog/{slug}', name: 'blog_show')]
    public function show(string $slug, EntityManagerInterface $entityManager): Response
    {
        $post = $entityManager->getRepository(Post::class)->findOneBy(['slug' => $slug]);

        if (!$post) {
            throw $this->createNotFoundException('Post not found');
        }

        return $this->render('blog/single.html.twig', [
            'post' => $post,
        ]);
    }
}

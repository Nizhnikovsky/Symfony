<?php
namespace BlogBundle\Service;
use BlogBundle\Entity\Post;
use Doctrine\ORM\EntityManager;

class PostService
{
    private $em;
    private $postRepository;
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
        $this->postRepository = $entityManager->getRepository('BlogBundle:Post');
    }
    public function getPosts()
    {
        return $this->postRepository->findAll();
    }
    public function getPostById($id)
    {
        $post = $this->postRepository->find($id);
        if (!$post) {
            throw new \Exception("Post not found");
        }
        return $post;
    }
    public function createPost(Post $post)
    {
        $postExists = $this->postRepository->findOneBy(array('title' => $post->getTitle()));
        if ($postExists) {
            throw new \Exception("Post already exists");
        }
        
        $this->postRepository->save($post);
        return $post->getId();
    }
}
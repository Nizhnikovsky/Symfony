<?php

namespace BlogBundle\Controller;

use BlogBundle\Form\PostType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use BlogBundle\Entity\Post;

class PostController extends Controller
{
    /**
     * @Route("/posts",name="get_posts")
     */
    public function indexAction()
    {
        $doctrine = $this->get('doctrine');
        $posts = $doctrine
            ->getRepository('BlogBundle:Post')
            ->findAll();
        return $this->render('BlogBundle:Default:index.html.twig', array(
            'posts' => $posts
        ));
    }

    /**
     * @Route("/post/{id}",name="get_post")
     * @param $id
     */
    public function getPostAction($id)
    {
        $doctrine = $this->get('doctrine');
        $post = $doctrine
            ->getRepository('BlogBundle:Post')
            ->find($id);
        return $this->render('BlogBundle:Default:get_post.html.twig', array(
            'post' => $post
        ));
    }

    /**
     * @Route("/create",name="create_post")
     *
     */
    public function createAction(Request $request)
    {
        if ($this->isGranted('ROLE_ADMIN')) {
        $post = new Post();
        $form = $this->createForm(new PostType(), $post);
        $form->handleRequest($request);
        if ($form->isValid() && $form->isSubmitted()) {
            $postRepository = $this->get('doctrine')
                ->getRepository('BlogBundle:Post');
            $post->setCreatedAt(new \DateTime());
            $postRepository->save($post);
            return $this->redirectToRoute('get_posts');
        }
        return $this->render('@Blog/Default/create.html.twig', array(
            'form' => $form->createView()
        ));
    } else {
        return $this->render('access_denied.html.twig');
    }
    }

    /**
     * @Route("/update",name="update_post")
     */
    public function updateAction()
    {
        $doctrine = $this->get('doctrine');
        $postRepository = $doctrine->getRepository('BlogBundle:Post');
        $post = $postRepository->find(1);
        $post->setTitle('Post test');
        $post->setBody('sdfivbuisdfnbvldfi');
        $postRepository->save($post);
        return $this->redirectToRoute('get_posts');
    }

    /**
     * @Route("/delete",name="delete_post")
     */
    public function deleteAction()
    {
        $doctrine = $this->get('doctrine');
        $em = $doctrine->getManager();
        $post = $doctrine->getRepository('BlogBundle:Post')
            ->find(1);
        $em->remove($post);
        $em->flush();
        return $this->redirectToRoute('get_posts');
    }

}

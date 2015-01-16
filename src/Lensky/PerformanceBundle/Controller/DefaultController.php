<?php

namespace Lensky\PerformanceBundle\Controller;

use Lensky\PerformanceBundle\Entity\Post;
use Lensky\PerformanceBundle\Entity\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{

    /**
     * Homepage
     *
     * @return array
     *
     * @Route("/", name="index")
     * @Template()
     */
    public function indexAction()
    {
        return [];
    }
    /**
     * Get list of posts by not optimized query
     *
     * @Route("/list-posts", name="list_posts")
     * @Template(template="@LenskyPerformance/Default/list_posts.html.twig")
     *
     * @return array
     */
    public function listPostsAction()
    {
        $posts = $this->getDoctrine()->getRepository('LenskyPerformanceBundle:Post')->findAll();

        return array('posts' => $posts);
    }

    /**
     * Get list of posts by optimized query
     *
     * @Route("/list-posts-optimized", name="list_posts_optimized")
     * @Template(template="@LenskyPerformance/Default/list_posts.html.twig")
     *
     * @return array
     */
    public function listPostsOptimizedAction()
    {
        /** @var PostRepository $postRepository */
        $postRepository = $this->getDoctrine()->getRepository('LenskyPerformanceBundle:Post');
        $posts = $postRepository->findAllPostsAndAuthors();

        return array('posts' => $posts);
    }

    /**
     * Update posts created date not optimized
     *
     * @Route("/update-posts", name="update_posts")
     * @Template(template="@LenskyPerformance/Default/update_posts.html.twig")
     *
     * @return array
     */
    public function updatePostsAction()
    {
        $newCreatedAt = new \DateTime();
        $posts = $this->getDoctrine()->getRepository('LenskyPerformanceBundle:Post')->findAll();

        /** @var Post $post */
        foreach ($posts as $post) {
            $post->setCreatedAt($newCreatedAt);
        }
        $this->getDoctrine()->getManager()->flush();

        return array();
    }

    /**
     * Update posts created date optimized
     *
     * @Route("/update-posts-optimized", name="update_posts_optimized")
     * @Template(template="@LenskyPerformance/Default/update_posts.html.twig")
     *
     * @return array
     */
    public function updatePostsOptimizedAction()
    {
        $newCreatedAt = new \DateTime();
        $this->getDoctrine()->getRepository('LenskyPerformanceBundle:Post')->updateCreatedAtForAllPosts($newCreatedAt);

        return array();
    }

    /**
     * Create new post without reference proxies
     *
     * @param int $id
     *
     * @return array
     *
     * @Route("/create-post/{id}", name="create_post")
     * @Template(template="@LenskyPerformance/Default/create_post.html.twig")
     */
    public function createPostAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $author = $em->getRepository('LenskyPerformanceBundle:Author')->find($id);

        $post = new Post();
        $post->setAuthor($author)
            ->setText('Some text...')
            ->setTitle('New post created without Reference Proxies')
            ->setCreatedAt(new \DateTime());


        $em->persist($post);
        $em->flush();

        return array('post' => $post);
    }


    /**
     * Create new post with reference proxies
     *
     * @param int $id
     *
     * @return array
     *
     * @Route("/create-post-optimized/{id}", name="create_post_optimized")
     * @Template(template="@LenskyPerformance/Default/create_post.html.twig")
     */
    public function createPostOptimizedAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $post = new Post();
        $post->setAuthor($em->getReference('Lensky\PerformanceBundle\Entity\Author', $id))
            ->setText('Some text...')
            ->setTitle('New post created with Reference Proxies')
            ->setCreatedAt(new \DateTime());


        $em->persist($post);
        $em->flush();

        return array('post' => $post);
    }

    /**
     * List titles of posts used hydration objects
     *
     * @return array
     *
     * @Route("/list-posts-hydrated-objects", name="list_posts_hydrated_objects")
     * @Template(template="@LenskyPerformance/Default/list_posts_titles.html.twig")
     */
    public function listPostsHydratedObjectsAction()
    {
        $postRepository = $this->getDoctrine()->getRepository('LenskyPerformanceBundle:Post');

        $posts = $postRepository->findAll();

        return array('posts' => $posts);
    }

    /**
     * List titles of posts used hydration array
     *
     * @return array
     *
     * @Route("/list-posts-hydrated-array", name="list_posts_hydrated_array")
     * @Template(template="@LenskyPerformance/Default/list_posts_titles.html.twig")
     */
    public function listPostsHydratedArrayAction()
    {
        $postRepository = $this->getDoctrine()->getRepository('LenskyPerformanceBundle:Post');

        $posts = $postRepository->findAllPostsAsArray();

        return array('posts' => $posts);
    }
}

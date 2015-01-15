<?php

namespace Lensky\PerformanceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * Get list of posts by not optimized query
     *
     * @Route("/posts", name="list_posts")
     * @Template(template="@LenskyPerformance/Default/list_posts.html.twig")
     *
     * @return array
     */
    public function listPostsAction()
    {
        $posts = $this->getDoctrine()->getRepository('LenskyPerformanceBundle:Post')->findBy([], ['createdAt' => 'asc']);

        return array('posts' => $posts);
    }

    /**
     * Get list of posts by optimized query
     *
     * @Route("/posts-optimized", name="list_posts_optimized")
     * @Template(template="@LenskyPerformance/Default/list_posts.html.twig")
     *
     * @return array
     */
    public function listPostsOptimizedAction()
    {
        $posts = $this->getDoctrine()->getRepository('LenskyPerformanceBundle:Post')->findPostsAndAuthors(['createdAt' => 'asc']);

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
}

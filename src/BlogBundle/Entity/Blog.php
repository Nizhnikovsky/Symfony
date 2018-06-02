<?php

namespace BlogBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;

/**
 * Blog
 *
 * @ORM\Table(name="blog")
 * @ORM\Entity(repositoryClass="BlogBundle\Repository\BlogRepository")
 */
class Blog
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=100)
     */
    private $title;
    
    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User", inversedBy="blogs")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;
    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="BlogBundle\Entity\Post", mappedBy="blog")
     */
    private $posts;
    public function __construct()
    {
        $this->posts = new ArrayCollection();
    }
    
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Blog
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
    
    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
    /**
     * @param User $user
     * @return Blog
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }
    /**
     * @return ArrayCollection
     */
    public function getPosts()
    {
        return $this->posts;
    }
    /**
     * @param ArrayCollection $posts
     * @return Blog
     */
    public function setPosts($posts)
    {
        $this->posts = $posts;
        return $this;
    }
    public function addPost(Post $post)
    {
        $this->posts->add($post);
        return $this;
    }
}


<?php
namespace UserBundle\Service;
use UserBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use UserBundle\Entity\Role;


class UserService
{
    private $em;
    private $userRepository;
    private $roleRepository;
    private $encoder;
    public function __construct(EntityManager $entityManager,UserPasswordEncoder $encoder)
    {
        $this->em = $entityManager;
        $this->userRepository = $entityManager->getRepository('UserBundle:User');
        $this->roleRepository = $entityManager->getRepository(Role::class);
        $this->encoder = $encoder;
    }
    
    public function createUser(User $user,$user_role)
    {
        
        $findUser = $this->userRepository->findOneBy(array('username' => $user->getUsername()));
        if ($findUser) {
            throw new \Exception("User already exists");
        }
        $password = $this->encoder->encodePassword($user, $user->getPassword());
        $user->setPassword($password);
        $userRole = $this->roleRepository->findOneBy(array(
            'name' => $user_role
        ));
        $user->addRole($userRole);
        $this->userRepository->saveUser($user);
        return $user->getId();
    }
    
    public function getUserById($id)
    {
        $user = $this->userRepository->findOneBy($id);
        if (!$user) {
            throw new \Exception("User not found");
        }
        return $user;
    }
    
    public function getUserByName($username)
    {
        $user_by_name = $this->userRepository->findBy($username);
        if (!$user_by_name) {
            throw new \Exception("User not found");
        }
        return $user_by_name;
    }
    
    public function editUser($user_id)
    {
        try {
            $user = $this->getUserById($user_id);
            $password = $this->encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $userRole = $this->roleRepository->findOneBy(array(
                'name' => 'user'
            ));
            $user->addRole($userRole);
            $this->userRepository->saveUser($user);
            return $user->getId();
        } catch (\Exception $e) {
          return $e;
        }
       
//        //$findUser = $this->userRepository->findOneBy(array('username' => $user->getUsername()));
//        if (!$user) {
//            throw new \Exception("User not found");
//        }
    }
    
    public function deleteUser($id)
    {
        try {
            $user = $this->getUserById($id);
            return $this->userRepository->deleteUser($user);
        } catch (\Exception $e) {
            return $e;
        }
    }
    
    
//    public function getPosts()
//    {
//        return $this->postRepository->findAll();
//    }
//    public function getPostById($id)
//    {
//        $post = $this->postRepository->find($id);
//        if (!$post) {
//            throw new \Exception("Post not found");
//        }
//        return $post;
//    }
//    public function createPost(Post $post)
//    {
//        $postExists = $this->postRepository->findOneBy(array('title' => $post->getTitle()));
//        if ($postExists) {
//            throw new \Exception("Post already exists");
//        }
//        $this->postRepository->save($post);
//        return $post->getId();
//    }
}
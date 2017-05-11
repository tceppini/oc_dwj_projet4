<?php

namespace writerblog\Controller;

use writerblog\Domain\User;
use writerblog\Form\Type\RegisterType;
use Silex\Application;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use writerblog\Domain\Comment;
use writerblog\Form\Type\CommentType;

class HomeController {
    
    /**
     * Home page controller.
     *
     * @param Application $app Silex application
     */
    public function indexAction(Application $app) {
        $billets = $app['dao.billet']->readAll();
        return $app['twig']->render('index.html.twig', array('billets' => $billets));
    }

    /**
     * Billet details controller.
     *
     * @param integer $id Billet id
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function billetAction($id, Request $request, Application $app) {
        $billet = $app['dao.billet']->read($id);
        $commentFormView = null;
        if ($app['security.authorization_checker']->isGranted('IS_AUTHENTICATED_FULLY')) {
            $comment = new Comment();
            $comment->setAuthor($app['user']);
            $comment->setBillet($billet);
            $comment->setDate(date('Y-m-d H:i:s'));
            $commentForm = $app['form.factory']->create(CommentType::class, $comment);
            $commentForm->handleRequest($request);
            if ($commentForm->isSubmitted() && $commentForm->isValid()) {
                if ($comment->getContent() == null) {
                    $app['session']->getFlashBag()->add('notice', 'Your comment cannot be empty.');
                    return $app->redirect($app['url_generator']->generate('billet', array('id' => $id)));  
                } else {
                    $app['dao.comment']->save($comment);
                    $app['session']->getFlashBag()->add('success', 'Votre commentaire a été ajouté.');
                }
            }
            $commentFormView = $commentForm->createView();
        }
        $nbComments = $app['dao.billet']->countComments($id);
        $billet->setNbComments($nbComments);
        $app['dao.billet']->update($billet);

        $comments = $app['dao.comment']->readAllByIdBillet($id);
        
        return $app['twig']->render('billet.html.twig', array(
            'billet' => $billet,
            'comments' => $comments,
            'commentForm' => $commentFormView
            ));
    }

    /**
     * User login controller.
     *
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function loginAction(Request $request, Application $app) {
        return $app['twig']->render('login.html.twig', array(
            'error'         => $app['security.last_error']($request),
            'last_username' => $app['session']->get('_security.last_username')
            ));
    }
    
     /**
     * User registration controller.
     *
     * @param Request $request
     * @param Application $app Silex application
     * @return Response
     */
     public function registerAction(Request $request, Application $app)
     {
        $user = new User();
        $userForm = $app['form.factory']->create(RegisterType::class, $user);
        $userForm->handleRequest($request);
        if ($userForm->isSubmitted() && $userForm->isValid()) {
            // generate a random salt value
            $salt = substr(md5(time()), 0, 23);
            $user->setSalt($salt);
            $plainPassword = $user->getPassword();
            // find the default encoder
            $encoder = $app['security.encoder.bcrypt'];
            // compute the encoded password
            $password = $encoder->encodePassword($plainPassword, $user->getSalt());
            $user->setPassword($password);
            $user->setRole('ROLE_USER');
            $app['dao.user']->save($user);
            return $app->redirect($app['url_generator']->generate('login'));
        }
        return $app['twig']->render('register.html.twig', [
            'title'    => 'New user',
            'userForm' => $userForm->createView()
            ]);
    }
}

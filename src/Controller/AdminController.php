<?php

namespace writerblog\Controller;

use Silex\Application;
use writerblog\Domain\Billet;
use writerblog\Domain\User;
use writerblog\Form\Type\BilletType;
use writerblog\Form\Type\CommentType;
use writerblog\Form\Type\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormError;


class AdminController {

    /**
     * Admin home page controller.
     *
     * @param Application $app Silex application
     */
    public function indexAction(Application $app) {
        $billets = $app['dao.billet']->readAll();
        $comments = $app['dao.comment']->readAll();
        $users = $app['dao.user']->readAll();
        return $app['twig']->render('admin.html.twig', array(
            'billets' => $billets,
            'comments' => $comments,
            'users' => $users
            ));
    }

    /**
     * Add billet controller.
     *
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function billetAddAction(Request $request, Application $app) {
        $billet = new Billet();
        $billet->setDateAjout(date('Y-m-d'));
        $billet->setNbComments(0);
        $billetForm = $app['form.factory']->create(BilletType::class, $billet);
        $billetForm->handleRequest($request);
        if ($billetForm->isSubmitted() && $billetForm->isValid()) {
            $app['dao.billet']->create($billet);
            $app['session']->getFlashBag()->add('success', 'Votre billet a été ajouté.');
        }
        $billetFormView = $billetForm->createView();
        return $app['twig']->render('billet_form.html.twig', array(
            'billetForm' => $billetFormView,
            'title' => 'Ajouter un billet',
            'messageButton' => 'Ajouter'
            ));
    }

    /**
     * Edit billet controller.
     *
     * @param integer $id Billet id
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function billetEditAction($id, Request $request, Application $app) {
        $billet = $app['dao.billet']->read($id);
        $billet->setDateModif(date('Y-m-d'));
        $billetForm = $app['form.factory']->create(BilletType::class, $billet);        
        $billetForm->handleRequest($request);
        if ($billetForm->isSubmitted() && $billetForm->isValid()) {
            $app['dao.billet']->update($billet);
            $app['session']->getFlashBag()->add('success', 'Votre billet a été mis à jour.');
        }
        $billetFormView = $billetForm->createView();
        return $app['twig']->render('billet_form.html.twig', array(
            'billetForm' => $billetFormView,
            'title' => 'Editer un billet',
            'messageButton' => 'Modifier'            
            ));
    }

    /**
     * Delete billet controller.
     *
     * @param integer $id Billet id
     * @param Application $app Silex application
     */
    public function billetDeleteAction($id, Application $app) {
        $app['dao.comment']->deleteAllByIdBillet($id);
        $app['dao.billet']->deleteBillet($id);
        $app['session']->getFlashBag()->add('success', 'Votre billet a été supprimé.');
        return $app->redirect($app['url_generator']->generate('admin'));
    }

    /**
     * Edit comment controller.
     *
     * @param integer $id Comment id
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function commentEditAction($id, Request $request, Application $app) {
        $comment = $app['dao.comment']->read($id);
        $billet = $comment->getBillet();
        $commentForm = $app['form.factory']->create(CommentType::class, $comment);
        $commentForm->handleRequest($request);
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            if ($comment->getContent() == null) {
                $app['session']->getFlashBag()->add('notice', 'Votre commenatire ne peut être vide.');
                return $app->redirect($app['url_generator']->generate('admin_comment_edit', array('id' => $id)));  
            } else {
                $app['dao.comment']->save($comment);
                $app['session']->getFlashBag()->add('success', 'Votre commentaire a été mis à jour.');
            }
        }
        return $app['twig']->render('comment_form.html.twig', array(
            'commentForm' => $commentForm->createView(),
            'billet' => $billet
            ));
    }

    /**
     * Delete comment controller.
     *
     * @param integer $id Comment id
     * @param Application $app Silex application
     */
    public function commentDeleteAction($id, Request $request, Application $app) {
        // get billet object from a comment
        $comment = $app['dao.comment']->read($id);
        $billet = $comment->getBillet();
        // update amount of comments (remove one comment) to the associate billet 
        $nbComments = $billet->getNbComments() - 1;
        $billet->setNbComments($nbComments);
        // delete comment
        $app['dao.comment']->delete($id);
        // display the right amount of comments
        $app['dao.billet']->update($billet);
        // success message
        $app['session']->getFlashBag()->add('success', 'Votre commentaire a été supprimé.');        
        return $app->redirect($app['url_generator']->generate('admin'));        
    }

    /**
     * Add user controller.
     *
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
    public function userAddAction(Request $request, Application $app) {
        $user = new User();
        $userForm = $app['form.factory']->create(UserType::class, $user);
        $userForm->handleRequest($request);
        if ($userForm->isSubmitted() && $userForm->isValid()) {
            $username = $user->getUsername();
            $existingUser = $app['dao.user']->findUserByUsername($username);
            if (strtolower($existingUser->getUsername()) == strtolower($username)) {
                $app['session']->getFlashBag()->add('notice', 'Le nom d\'utilisateur existe déjà.');
                return $app->redirect($app['url_generator']->generate('admin_user_add'));  
            } elseif ($user->getPassword() == null) {
                $app['session']->getFlashBag()->add('notice', 'Le mot de passe ne doit pas être vide.');
                return $app->redirect($app['url_generator']->generate('admin_user_add'));        
            } else {
                $salt = substr(md5(time()), 0, 23);
                $user->setSalt($salt);
                $encoder = $app['security.encoder.bcrypt'];
                $password = $encoder->encodePassword($user->getPassword(), $user->getSalt());
                $user->setPassword($password); 
                $app['dao.user']->save($user);
                $app['session']->getFlashBag()->add('success', 'Un utilisateur a été crée.');
            }
        }
        return $app['twig']->render('user_form.html.twig', array(
            'userForm' => $userForm->createView(),
            'title' => 'Ajouter un utilisateur',
            'messageButton' => 'Ajouter'
            ));
    }

     /**
     * Edit user controller.
     *
     * @param integer $id User id
     * @param Request $request Incoming request
     * @param Application $app Silex application
     */
     public function userEditAction($id, Request $request, Application $app) {
        $user = $app['dao.user']->read($id);
        $oldUsername = $user->getUsername();
        $userForm = $app['form.factory']->create(UserType::class, $user);
        $userForm->handleRequest($request);
        if ($userForm->isSubmitted() && $userForm->isValid()) {
            $newUsername = $user->getUsername();
            $existingUserName = $app['dao.user']->findUserByUsername($newUsername)->getUsername();
            if (strtolower($oldUsername) != strtolower($newUsername) && strtolower($existingUserName) == strtolower($newUsername)) {
                $app['session']->getFlashBag()->add('notice', 'Vous venez de modifier le nom d\'utilisateur, mais celui-ci existe déjà.');
                return $app->redirect($app['url_generator']->generate('admin_user_edit', array('id' => $id)));  
            } elseif ($user->getPassword() == null) {
                $app['session']->getFlashBag()->add('notice', 'Le mot de passe ne doit pas être vide.');
                return $app->redirect($app['url_generator']->generate('admin_user_edit', array('id' => $id)));        
            } else {
                $password = $app['security.encoder.bcrypt']->encodePassword($user->getPassword(), $user->getSalt());
                $user->setPassword($password); 
                $app['dao.user']->save($user);
                $app['session']->getFlashBag()->add('success', 'Utilisateur mis à jour');
            }
        }
        return $app['twig']->render('user_form.html.twig', array(
            'userForm' => $userForm->createView(),
            'title' => 'Editer un utilisateur',
            'messageButton' => 'Modifier'
            ));
    }

/**
     * Delete user controller.
     *
     * @param integer $id User id
     * @param Application $app Silex application
     */
public function userDeleteAction($id, Application $app) {
        // delete all comments from a user
    $app['dao.comment']->deleteAllByIdUser($id);
        // delete the user
    $app['dao.user']->delete($id);
        // update amount of comments to every billet
    $billets = $app['dao.billet']->readAll();
    foreach ($billets as $billet) {
        $nbComments = $app['dao.billet']->countComments($billet->getId());
        $billet->setNbComments($nbComments);
        $app['dao.billet']->update($billet);
    }
        // success message
    $app['session']->getFlashBag()->add('success', 'Utilisateur supprimé');        
    return $app->redirect($app['url_generator']->generate('admin'));        
}
}

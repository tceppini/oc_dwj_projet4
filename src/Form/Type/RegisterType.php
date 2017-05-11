<?php
/**
 * Created by PhpStorm.
 * User: tceppini
 * Date: 09/05/2017
 * Time: 12:20
 */

namespace writerblog\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('username', TextType::class)
        ->add('password', RepeatedType::class, [
            'type'            => PasswordType::class,
            'invalid_message' => 'Les champs du mot de passe doivent correspondre.',
            'options'         => ['label' => 'Identifiant'],
            'first_options'   => ['label' => 'Mot de passe'],
            'second_options'  => ['label' => 'Répéter mot de passe'],
            ]);
    }

    public function getUsername()
    {
        return 'user';
    }
}

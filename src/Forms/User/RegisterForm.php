<?php


namespace App\Forms\User;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegisterForm extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder
			->add('email', EmailType::class, [
				'constraints' => [
					new NotBlank([
						'message' => 'El campo email no puede estar vació'
					]),
					new Length([
						'min' => 5,
						'max' => 80,
						'minMessage' => 'Tiene que tener entre 5 y 50 caracteres',
						'maxMessage' => 'Tiene que tener entre 5 y 50 caracteres'
					])
				]
			])
			->add('password', PasswordType::class, [
				'constraints' => [
					new NotBlank([
						'message' => 'El campo password no puede estar vacio'
					]),
					new Length([
						'min' => 8,
						'max' => 20,
						'minMessage' => 'Tiene que tener entre 8 y 20 caracteres',
						'maxMessage' => 'Tiene que tener entre 8 y 20 caracteres'
					])
				]
			])
			->add('agreeTerms', CheckboxType::class, [
				'constraints' => [
					new IsTrue([
						'message' => 'Debe acceder los terminos de uso'
					])
				]
			]);
	}



	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => User::class,
			'csrf_protection' => false,
		]);
	}

	public function getBlockPrefix()
	{
		return '';
	}
}
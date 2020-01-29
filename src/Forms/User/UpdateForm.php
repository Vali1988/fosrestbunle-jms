<?php


namespace App\Forms\User;


use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\BaseType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdateForm extends BaseType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('name', TextType::class)
			->add('lastname', TextType::class)
			->add('dob', DateType::class, [
				'widget' => 'single_text'
			]);
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'csrf_protection' => false,
			'data_class' => User::class,
		]);
	}

	public function getBlockPrefix()
	{
		return '';
	}
}
<?php


namespace App\Forms\Comment;


use App\Entity\Brand;
use App\Entity\CommentsBrand;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class CommentBrand extends CommentBase
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		parent::buildForm($builder, $options);
		$builder->add('brand', EntityType::class, [
			'constraints' => [
				new NotBlank(['message' => 'Brand is not empty'])
			],
			'multiple' => false,
			'class' => Brand::class
		]);
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => CommentsBrand::class,
			'csrf_protection' => false,
		]);
	}

	public function getBlockPrefix()
	{
		return '';
	}
}
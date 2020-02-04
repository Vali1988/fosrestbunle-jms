<?php


namespace App\Forms\Comment;

use App\Entity\CommentsProduct;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class CommentProduct extends CommentBase
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		parent::buildForm($builder, $options);
		$builder->add('product', EntityType::class, [
			'constraints' => [
				new NotBlank(['message' => 'Brand is not empty'])
			],
			'multiple' => false,
			'class' => Product::class
		]);
	}

	public function configureOptions(OptionsResolver $resolver)
	{
		$resolver->setDefaults([
			'data_class' => CommentsProduct::class,
			'csrf_protection' => false,
		]);
	}

	public function getBlockPrefix()
	{
		return '';
	}
}
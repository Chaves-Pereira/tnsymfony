<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

/**
* 
*/
class PageType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options) {
		$builder
			->add('title', TextType::class)
			->add('content', TextareaType::class)
			
			->add('categories', EntityType::class, array(
				'class' => 'App\Entity\Category',
				'choice_label' => 'name',
				'multiple' => true,
				'expanded' => true,
				'required' => false,
			))
			->add('published', CheckboxType::class, array(
				'required' => false,
			))
			->add('save', SubmitType::class)
		;
	}

	public function configureOptions(OptionsResolver $resolver) {
		$resolver->setDefaults(array(
			'data_class' => 'App\Entity\Page',
		));
	}
}
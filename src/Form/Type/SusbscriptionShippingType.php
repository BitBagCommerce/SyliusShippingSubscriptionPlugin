<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusShippingSubscriptionPlugin\Form\Type;

use Sylius\Bundle\MoneyBundle\Form\Type\MoneyType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Type;

final class SusbscriptionShippingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('amount', MoneyType::class, [
                  'label' => 'bitbag_sylius_shipping_subscription.form.shipping_calculator.subscription_shipping_configuration.amount',
                'constraints' => [
                    new NotBlank(['groups' => ['sylius']]),
                    new Range(['min' => 0, 'minMessage' => 'sylius.shipping_method.calculator.min', 'groups' => ['sylius']]),
                    new Type(['type' => 'integer', 'groups' => ['sylius']]),
                ],
            ])
            ->add('min_amount', MoneyType::class, [
                'label' => 'bitbag_sylius_shipping_subscription.form.shipping_calculator.subscription_shipping_configuration.min_amount',
                'constraints' => [
                    new NotBlank(['groups' => ['sylius']]),
                    new Range(['min' => 0, 'minMessage' => 'sylius.shipping_method.calculator.min', 'groups' => ['sylius']]),
                    new Type(['type' => 'integer', 'groups' => ['sylius']]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);

        $resolver
            ->setDefaults([
                'data_class' => null,
                'min_amount' => 0,
            ])
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'bitbag_shipping_calculator_subscription_shipping';
    }
}

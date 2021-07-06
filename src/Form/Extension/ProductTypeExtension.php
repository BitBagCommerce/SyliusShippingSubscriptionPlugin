<?php

declare(strict_types=1);

namespace BitBag\SyliusShippingSubscriptionPlugin\Form\Extension;

use Sylius\Bundle\ProductBundle\Form\Type\ProductType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;

final class ProductTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
      ->add('shippingSubscription', CheckboxType::class, [
        'required' => false,
        'label' => 'bitbag_sylius_shipping_subscription.form.product.shipping_subscription',
      ]);
    }

    public static function getExtendedTypes(): iterable
    {
        return [ProductType::class];
    }
}

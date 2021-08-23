<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace BitBag\SyliusShippingSubscriptionPlugin\Form\Extension;

use BitBag\SyliusShippingSubscriptionPlugin\Entity\ProductShippingSubscriptionAwareInterface;
use BitBag\SyliusShippingSubscriptionPlugin\Entity\ProductVariantInterface;
use Sylius\Bundle\ProductBundle\Form\Type\ProductVariantType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;

final class ProductVariantTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var ProductVariantInterface $productVariant */
        $productVariant = $builder->getData();

        $isSubscription = false;

        if (null !== $productVariant) {
            /** @var ProductShippingSubscriptionAwareInterface $product */
            $product = $productVariant->getProduct();
            $isSubscription = $product->isShippingSubscription();
        }

        $builder
            ->add(
                'subscriptionLength',
                NumberType::class,
                [
                    'label' => 'bitbag_sylius_shipping_subscription.form.shipping.length',
                    'required' => false,
                    'attr' => ['is-subscription' => $isSubscription],
                ]
            );
    }

    public static function getExtendedTypes(): iterable
    {
        return [ProductVariantType::class];
    }
}

<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
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
                ],
            );
    }

    public static function getExtendedTypes(): iterable
    {
        return [ProductVariantType::class];
    }
}

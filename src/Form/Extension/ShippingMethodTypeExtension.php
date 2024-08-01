<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusShippingSubscriptionPlugin\Form\Extension;

use Sylius\Bundle\MoneyBundle\Form\Type\MoneyType;
use Sylius\Bundle\ShippingBundle\Form\Type\ShippingMethodType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;

final class ShippingMethodTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('shipping_subscription', CheckboxType::class, [
                'label' => 'bitbag_sylius_shipping_subscription.form.shipping.is_shipping_subscription_required',
            ])
            ->add('availableFromTotal', MoneyType::class, [
                'label' => 'bitbag_sylius_shipping_subscription.form.shipping.from_total',
                'required' => false,
            ])
        ;
    }

    public static function getExtendedTypes(): iterable
    {
        return [ShippingMethodType::class];
    }
}

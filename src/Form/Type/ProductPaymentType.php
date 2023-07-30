<?php
namespace App\Form\Type;

use App\Dto\ProductPaymentDto;
use App\Entity\Enums\CouponDiscountTypeEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductPaymentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('product', IntegerType::class, [
                'required' => true,
            ])
            ->add('taxNumber', TextType::class, [
                'required' => true,
            ])
            ->add('couponCode', TextType::class, [
                'required' => false,
            ])
            ->add('paymentProcessor', TextType::class, [
                'required' => true,
            ])
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProductPaymentDto::class,
        ]);
    }
}
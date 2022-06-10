<?php


namespace PaLabs\DatagridBundle\Form\Type;


use BackedEnum;
use ReflectionClass;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class EnumForm extends AbstractType
{

    public function __construct(private readonly TranslatorInterface $translator)
    {
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $choiceBuilder = function (Options $options) {
            /** @var BackedEnum $enum */
            $enum = $options['type'];
            $choices = [];
            $values = isset($options['items']) ? $options['items'] : $enum::cases();

            foreach ($values as $value) {
                $translatedLabel = $this->translateEnum($value, $options);
                $choices[$translatedLabel] = $value;
            }
            return $choices;
        };

        $choiceResolver = function ($value = null) {
            return match (true) {
                $value === null => null,
                $value instanceof BackedEnum => $value->name,
                default => $value
            };
        };


        $resolver
            ->setDefaults([
                'value_translation_domain' => 'enums',
                'choices' => $choiceBuilder,
                'choice_value' => $choiceResolver
            ])
            ->setRequired(['type'])
            ->setDefined(['items']);

    }

    private function translateEnum(BackedEnum $enum, Options $options): string
    {
        $transId = sprintf('%s.%s', (new ReflectionClass($enum))->getShortName(), $enum->name);
        return $this->translator->trans($transId, [], $options['value_translation_domain']);
    }

    public function getParent(): string
    {
        return ChoiceType::class;
    }
}
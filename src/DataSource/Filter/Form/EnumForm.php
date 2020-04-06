<?php


namespace PaLabs\DatagridBundle\DataSource\Filter\Form;


use PaLabs\Enum\Enum;
use ReflectionClass;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;

class EnumForm extends AbstractType
{
    private TranslatorInterface $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $choiceBuilder = function (Options $options) {
            /** @var Enum $enum */
            $enum = $options['type'];
            $choices = [];
            $values = isset($options['items']) ? $options['items'] : $enum::values();

            foreach ($values as $value) {
                $translatedLabel = $this->translateEnum($value, $options);
                $choices[$translatedLabel] = $value;
            }
            return $choices;
        };

        $choiceResolver = function ($value = null) {
            if ($value === null) {
                return null;
            }
            if ($value instanceof Enum) {
                return $value->name();
            }
            return $value;
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

    private function translateEnum(Enum $enum, Options $options): string
    {
        $transId = sprintf('%s.%s', (new ReflectionClass($enum))->getShortName(), $enum->name());
        return $this->translator->trans($transId, [], $options['value_translation_domain']);
    }

    public function getParent()
    {
        return ChoiceType::class;
    }
}
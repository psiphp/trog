<?php

namespace Trog\Bundle\ObjectAgent\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Psi\Component\ObjectAgent\AgentFinder;
use Psi\Component\ObjectAgent\AgentInterface;

class ObjectReferenceType extends AbstractType
{
    private $agentFinder;

    public function __construct(AgentFinder $agentFinder)
    {
        $this->agentFinder = $agentFinder;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $class = $options['class'];

        $builder->addModelTransformer(new CallbackTransformer(

            // object to identifier
            function ($value) use ($class) {
                if (null === $value) {
                    return;
                }

                if (!is_object($value)) {
                    throw new \InvalidArgumentException(sprintf(
                        'Transformer expected an object but got a "%s"',
                        gettype($value)
                    ));
                }

                return $this->getAgent($class)->getIdentifier($value);
            },

            // identifier to object
            function ($value) use ($class) {
                $document = $this->getAgent($class)->find($value);

                return $document;
            }
        ));
    }

    public function configureOptions(OptionsResolver $options)
    {
        $options->setDefault('show_properties', false);
        $options->setDefault('browser', 'default');
        $options->setRequired('class');
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['browser'] = $options['browser'];
        $view->vars['class'] = $options['class'];
        $view->vars['show_properties'] = $options['show_properties'];
    }

    public function getParent()
    {
        return HiddenType::class;
    }

    public function getBlockPrefix()
    {
        return 'trog_object_agent_object_reference';
    }

    private function getAgent(string $class): AgentInterface
    {
        return $this->agentFinder->findAgentFor($class);
    }
}

<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\AppBundle\Entity\Pais;

class PersonaType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder ->add('apellido')
            ->add('nombres')
            ->add('tipoDocum', EntityType::class, array(
                'class' => 'AppBundle:TipoDocum',
                'choice_label' => 'descripcion'
            ))
            ->add('numeroDocumento')
            ->add('domicilio')
            ->add('fechaNacimiento')
            ->add('telefono')
            ->add('celular')
            ->add('correoElectronico')
            ->add('nacPais', EntityType::class, array(
                'class' => 'AppBundle:Pais',
                'choice_label' => 'descripcion'
            ))

//            ->add('nacProvincia', EntityType::class, array(
//                'class' => 'AppBundle:Provincia',
//                'choice_label' => 'descripcion'
//            ))
             ->add('nacLocalidad', EntityType::class, array(
                'class' => 'AppBundle:Localidad',
                'choice_label' => 'descripcion'
            ))
            ->add('estadoCivil', EntityType::class, array(
                'class' => 'AppBundle:Estadocivil',
                'choice_label' => 'descripcion'
            ))
            ->add('resiPais', EntityType::class, array(
                'class' => 'AppBundle:Pais',
                'choice_label' => 'descripcion'
                ))
            ->add('resiProvincia', EntityType::class, array(
                'class' => 'AppBundle:Provincia',
                'choice_label' => 'descripcion'
            ))
                ->add('resiLocalidad', EntityType::class, array(
                'class' => 'AppBundle:Localidad',
                'choice_label' => 'descripcion'
            ))
            ->add('genero', EntityType::class, array(
                'class' => 'AppBundle:Genero',
                'choice_label' => 'descripcion'
            ))
            ->add('activo');

            $formModifier = function (FormInterface $form, Pais $Pais = null) {
                $nacProvincia = null === $Pais ? array() : $Pais->getProvincias();

                $form->add('nacProvincia', EntityType::class, array(
                    'class' => 'AppBundle:Provincia',
                    'placeholder' => '',
                    'choices' => $nacProvincia,
                ));
            };

            $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {
                // this would be your entity, i.e. SportMeetup
                $data = $event->getData();

                $formModifier($event->getForm(), $data->getNacPais());
            }
            );

            $builder->get('nacPais')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                // It's important here to fetch $event->getForm()->getData(), as
                // $event->getData() will get you the client data (that is, the ID)
                $sport = $event->getForm()->getData();

                // since we've added the listener to the child, we'll have to pass on
                // the parent to the callback functions!
                $formModifier($event->getForm()->getParent(), $nacPais);
            }
            );

             $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
                    $event->stopPropagation();
                }, 900);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Persona'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_persona';
    }




}

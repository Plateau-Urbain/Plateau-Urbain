<?php

namespace AppBundle\Admin;

use AppBundle\Entity\User;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Form\Type\DatePickerType;
use Sonata\UserBundle\Admin\Entity\UserAdmin as BaseAdmin;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserAdmin extends BaseAdmin
{
    protected $baseRoutePattern = 'utilisateurs';
    protected $baseRouteName = 'utilisateurs';

    /**
     * {@inheritdoc}
     * Utilise "birthday" (champ réel en base) au lieu de "dateOfBirth" (Sonata).
     */
    protected function configureFormFields(FormMapper $formMapper): void
    {
        parent::configureFormFields($formMapper);
        $formMapper->remove('dateOfBirth');
        $formMapper->remove('gender'); // l'app utilise "civility", pas gender
        $now = new \DateTime();
        $formMapper->tab('User')->with('Profile')
            ->add('birthday', DatePickerType::class, [
                'label'       => 'Date de naissance',
                'format'      => 'dd/MM/yyyy',
                'years'       => range(1900, (int) $now->format('Y')),
                'dp_min_date' => '1-1-1900',
                'dp_max_date' => $now->format('c'),
                'required'    => false,
                'attr'        => ['placeholder' => 'JJ/MM/AAAA'],
                'help'        => 'Format attendu : JJ/MM/AAAA (ex. 15/03/1990)',
            ])
            ->add('civility', ChoiceType::class, [
                'label'       => 'Civilité',
                // Symfony ChoiceType : format libellé => valeur stockée en base
                'choices'     => ['M.' => User::MISTER, 'Mme' => User::MISS, 'Autre' => User::AUTRE],
                'required'    => false,
                'placeholder' => '-- Choisir --',
            ])
            ->add('preferredDepartments', ChoiceType::class, [
                'label'    => 'Départements souhaités',
                'choices'  => User::getAllFrenchDepartments(),
                'multiple' => true,
                'required' => false,
            ])
            ->end()->end();
    }

    /**
     * {@inheritdoc}
     * Affiche "birthday" au lieu de "dateOfBirth".
     */
    protected function configureShowFields(ShowMapper $showMapper): void
    {
        parent::configureShowFields($showMapper);
        $showMapper->remove('dateOfBirth');
        $showMapper->remove('gender');
        $showMapper->with('Profile')
            ->add('birthday', null, ['label' => 'Date de naissance'])
            ->add('civility', null, ['label' => 'Civilité'])
            ->add('preferredDepartmentsLabelsForExport', null, ['label' => 'Départements souhaités'])
            ->end();
    }
}

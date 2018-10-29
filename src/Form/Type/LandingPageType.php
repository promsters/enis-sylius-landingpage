<?php

namespace Enis\SyliusLandingPagePlugin\Form\Type;

use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\ChoiceList\Loader\CallbackChoiceLoader;

final class LandingPageType extends AbstractResourceType
{
    /** @var $file_locator FileLocator */
    private $file_locator;

    public function __construct($dataClass, $file_locator, $validationGroups = [])
    {
        $this->file_locator = $file_locator;
        parent::__construct($dataClass, $validationGroups);
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'app.form.landingpage.name',
                'required' => true
            ])
            ->add('slug', TextType::class, [
                'label' => 'app.form.landingpage.slug',
                'required' => true
            ])
            ->add('template', ChoiceType::class, [
                'label' => 'app.form.landingpage.template',
                'required' => true,
                'choice_loader' => new CallbackChoiceLoader(function() {
                    return $this->test();
                }),
            ])
            ->add('startsAt', DateTimeType::class, [
                'label' => 'app.form.landingpage.starts_at',
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
                'required' => false,
            ])
            ->add('endsAt', DateTimeType::class, [
                'label' => 'app.form.landingpage.ends_at',
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
                'required' => false,
            ])
        ;
    }

    public function test() {
        $finder = new Finder();
        $path = $this->file_locator->locate('/app/templates/LandingPage/');
        $files = $finder->files()->name('*.html.twig')->depth('== 0')->in($path);

        $choice = [];
        foreach($files as $key => $file) {
            /** @var $file \SplFileInfo */
            $choice[$file->getFilename()] = $file->getFilename();
        }

        return $choice;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'app_landingpage';
    }
}

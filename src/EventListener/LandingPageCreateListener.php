<?php

namespace Enis\SyliusLandingPagePlugin\EventListener;

use Enis\SyliusLandingPagePlugin\Entity\LandingPage;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\EventDispatcher\GenericEvent;
use Webmozart\Assert\Assert;
use Symfony\Component\Yaml\Yaml;

class LandingPageCreateListener
{
    private $locator;

    public function __construct(FileLocator $fileLocator)
    {
        $this->locator = $fileLocator;
    }

    public function onLandingPageCreate(GenericEvent $event) : void
    {
        /** @var LandingPage $landingpage */
        $landingpage = $event->getSubject();
        Assert::isInstanceOf($landingpage, LandingPage::class);

        $routes = $this->getRouting();

        $routes[$this->getRouteName($landingpage->getId())] = ['path' => '/' . $landingpage->getSlug(), 'controller' => 'Enis\SyliusLandingPagePlugin\Controller\LandingPageController::show'];

        $this->setRouting($routes);
    }

    public function onLandingPageDelete(GenericEvent $event) : void
    {
        /** @var LandingPage $landingpage */
        $landingpage = $event->getSubject();
        Assert::isInstanceOf($landingpage, LandingPage::class);

        $routes = $this->getRouting();

        unset($routes[$this->getRouteName($landingpage->getId())]);

        $this->setRouting($routes);
    }

    private function getRouting() : ?array
    {
        return Yaml::parseFile($this->getFilePath());
    }

    private function setRouting(?array $routes) : void
    {
        $yaml = Yaml::dump($routes);

        file_put_contents($this->getFilePath(), $yaml);
    }

    private function getFilePath() : string
    {
        return $this->locator->locate('@SyliusLandingPagePlugin/Resources/config/routing.yml');
    }

    private function getRouteName(int $id) : string
    {
        return 'app_public_landingpage_' . $id;
    }
}
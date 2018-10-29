<?php

namespace Enis\SyliusLandingPagePlugin\Menu;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class AdminMenuListener
{
    /**
     * @param MenuBuilderEvent $event
     */
    public function addAdminMenuItems(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu()->getChild('marketing');
        $menu->addChild('landingpage', ['route' => 'app_admin_landingpage_index'])
            ->setLabel('Landing page')
            ->setLabelAttribute('icon', 'newspaper outline');
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: tomasz.ptak
 * Date: 26.10.2018
 * Time: 11:29
 */

namespace Enis\SyliusLandingPagePlugin\Controller;

use Enis\SyliusLandingPagePlugin\Entity\LandingPage;
use Enis\SyliusLandingPagePlugin\Repository\LandingPageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LandingPageController extends AbstractController
{
    public function show($_route)
    {
        /** @var LandingPageRepository $repository */
        $repository = $this->getDoctrine()->getManager()->getRepository(LandingPage::class);

        $id = (int) explode('_', $_route)['3'];

        $template = $repository->getActiveById($id);

        if(empty($template)) throw $this->createNotFoundException('This landing page is no longer available.');

        return $this->render('@SyliusLandingPagePlugin/' . $template[0]['template']);
    }
}
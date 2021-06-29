<?php

namespace App\Controller;

use Exception;
use Pimcore\Controller\FrontendController;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Routing\Annotation\Route;
use \Pimcore\Model\DataObject;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use App\Form\Type\TaskType;
use Carbon\Carbon;
use Pimcore\Model\DataObject\Plane;

class DefaultController extends FrontendController
{
    /**
     * @Template
     * @param Request $request
     * @return array
     */
    public function defaultAction(Request $request)
    {
        $newFlight = new DataObject\Flight();

        $form = $this->createForm(TaskType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $newFlight->setKey(\Pimcore\Model\Element\Service::getValidKey($data['number'], 'object'));
            $newFlight->setParentId(15);
            $newFlight->setNumber($data['number']);
            $newFlight->setFrom($data['from']);
            $newFlight->setTo($data['to']);
            $newFlight->setDateFlight(new Carbon($data['dateFlight']));
            $newFlight->setPlane($data['plane']);
            $newFlight->setCargos($data['cargo']);
            try {
                $newFlight->save();
                $this->addFlash('success', 'Flight number was saved');
            } catch (\Exception $e) {
                $this->addFlash('error', 'This number is not valid');
            }
        }elseif ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash('validError', 'Each field must not be EMPTY, try again!');
        }
        return $this->render('default/default.html.twig', [
            'form_flight' => $form->createView(),
        ]);
    }
}
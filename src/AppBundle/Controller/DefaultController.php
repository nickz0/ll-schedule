<?php

namespace AppBundle\Controller;

use AppBundle\Form\ActType;
use AppBundle\Entity\Act;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{

    protected $em;

    /**
     * DefaultController constructor.
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Show event in calendar.
     */
    public function indexAction(Request $request)
    {
        $acts = $this->em->getRepository(Act::class)->findAll();
        $actsPerStage = $this->filterByStage($acts);

        return $this->render('default/index.html.twig', [
            'acts' => $actsPerStage,
            'eventdate' => '18-08-2017'
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function newAction(Request $request)
    {
        $act = new Act();
        $form = $this->createForm(ActType::class, $act);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $act = $form->getData();

            $this->em->persist($act);
            $this->em->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('default/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Filter by stage.
     *
     * @param $acts
     * @return array
     */
    private function filterByStage($acts)
    {
        $data =[];
        foreach($acts as $act){
            $data[$act->getStage()][] = $act;
        }
        return $data;

    }
}

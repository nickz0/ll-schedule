<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Act;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Date;

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
    public function indexAction(Request $request, string $day = null): Response
    {
        // default day is today (based on day name)
        if(is_null($day) ) {
            $day = strtolower(date('l'));
        }

        switch($day) {
            case 'friday' :
                $date = new DateTime("18-08-2017 8:00:00");
                break;
            case 'saturday' :
                $date = new DateTime("19-08-2017 8:00:00");
                break;
            case 'sunday' :
                $date = new DateTime("20-08-2017 8:00:00");
                break;
            default :
                $date = new DateTime("18-08-2017 8:00:00");
                break;
        }

        $acts = $this->em->getRepository(Act::class)->findByDay(clone $date);
        $actsPerStage = $this->filterByStage($acts);

        return $this->render('default/index.html.twig', [
            'acts' => $actsPerStage,
            'eventdate' => date('d-m-Y', $date->getTimestamp())
        ]);
    }

    /**
     * Detail page of an Act.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function showAction(Request $request, int $id): Response
    {
        $act = $this->em->getRepository(Act::class)->find($id);

        return $this->render('default/show.html.twig', [
            'act' => $act
        ]);
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

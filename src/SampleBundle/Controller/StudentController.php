<?php

namespace SampleBundle\Controller;

use SampleBundle\Services\CommunicationManager;
use SampleBundle\Services\StudentService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class StudentController extends Controller
{
    /** @var StudentService */
    private $studentService;

    /** @var CommunicationManager */
    private $communicationManager;

    public function __construct(StudentService $studentService, CommunicationManager $communicationManager)
    {
        $this->studentService = $studentService;
        $this->communicationManager = $communicationManager;
    }

    /**
     * @Route("/add", methods={"POST"}, name="add-student")
     * @param Request $request
     *
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $data = $request->getContent();
        $data = json_decode($data);
        $name = $data->name;
        $family = $data->family;
        $age = $data->age;

        $studentId = $this->studentService->addNewStudent($name, $family, $age);

        $this->communicationManager->publishEmail(
            'admin@site.com',
            'New student has been added successfully',
            $studentId,
            CommunicationManager::COMMUNICATION_PRIORITY_LEVEL_5
        );

        return new JsonResponse([
            'id' => $studentId,
            'Name' => $name,
            'Family' => $family,
            'Age' => $age
        ]);
    }
}
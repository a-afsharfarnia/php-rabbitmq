<?php

namespace SampleBundle\Services;

use Doctrine\ORM\EntityManagerInterface;
use SampleBundle\Entity\Student;

class StudentService
{
    /** @var EntityManagerInterface */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param string $name
     * @param string $family
     * @param int    $age
     *
     * @return int
     */
    public function addNewStudent(string $name, string $family, int $age): int
    {
        $student = new Student();

        $student->setName($name);
        $student->SetFamily($family);
        $student->setAge($age);

        $this->em->persist($student);
        $this->em->flush();

        return $student->getId();
    }
}
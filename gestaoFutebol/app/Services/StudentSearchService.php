<?php
namespace SIEC\Services;

use SIEC\Repositories\StudentRepositoryInterface;

class StudentSearchService
{
    private $studentRepository;

    public function __construct(StudentRepositoryInterface $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    public function findStudent($processId, $identificationDocument)
    {
        $students =  $this->studentRepository->findByIdentificationDocument($identificationDocument);
        
        foreach($students as $student){
            $studentAlreadyWasAssociateProcessSelected = $student->getSubscriptions()->where('process_id', $processId);
            if($studentAlreadyWasAssociateProcessSelected->isNotEmpty()) 
                throw new \Exception("Certidão de nascimento já cadastrada. Verifique o número inserido e corrija para prosseguir.");
        }

        return $students->isNotEmpty() 
            ? $students->first()
            : $this->studentRepository->newEmptyInstance();        
    }
}

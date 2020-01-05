<?php

namespace SIEC\Services;

use Carbon\Carbon;
use Illuminate\Database\DatabaseManager;
use Laracsv\Export;
use SIEC\Domain\Address\AddressInterface;
use SIEC\Domain\Process\ProcessInterface;
use SIEC\Domain\Student\StudentInterface;
use SIEC\Services\ProtocolGeneratorService;
use SIEC\Repositories\SchoolRepositoryInterface;
use SIEC\Domain\Responsible\ResponsibleInterface;
use SIEC\Domain\VOs\Filters;
use SIEC\Repositories\AddressRepositoryInterface;
use SIEC\Repositories\ProcessRepositoryInterface;
use SIEC\Repositories\StudentRepositoryInterface;
use SIEC\Repositories\DistrictRepositoryInterface;
use SIEC\Repositories\ResponsibleRepositoryInterface;
use SIEC\Repositories\SchoolGradeRepositoryInterface;
use SIEC\Repositories\SubscriptionRepositoryInterface;

class SubscriptionService
{
    private $databaseManager;
    private $responsibleRepository;
    private $districtRepository;
    private $addressRepository;
    private $studentRepository;
    private $schoolRepository;
    private $schoolGradeRepository;
    private $processRepository;
    private $subscriptionRepository;
    private $csvExporter;

    public function __construct(
        DatabaseManager $databaseManager,
        ResponsibleRepositoryInterface $responsibleRepository,
        DistrictRepositoryInterface $districtRepository,
        AddressRepositoryInterface $addressRepository,
        StudentRepositoryInterface $studentRepository,
        SchoolRepositoryInterface $schoolRepository,
        SchoolGradeRepositoryInterface $schoolGradeRepository,
        ProcessRepositoryInterface $processRepository,
        SubscriptionRepositoryInterface $subscriptionRepository,
        Export $csvExporter
    )
    {
        $this->databaseManager = $databaseManager;
        $this->responsibleRepository = $responsibleRepository;
        $this->districtRepository = $districtRepository;
        $this->addressRepository = $addressRepository;
        $this->studentRepository = $studentRepository;
        $this->schoolRepository = $schoolRepository;
        $this->schoolGradeRepository = $schoolGradeRepository;
        $this->processRepository = $processRepository;
        $this->subscriptionRepository = $subscriptionRepository;
        $this->csvExporter = $csvExporter;
    }

    private function createResponsible(array $attributes)
    {
        return $this->responsibleRepository->create(
            $attributes['responsible_name'],
            $attributes['responsible_identification_document'],
            $attributes['responsible_type_document']
        );
    }

    private function createAddres(array $attributes)
    {
        return  $this->addressRepository->create(
            $attributes['cep'],
            $attributes['city'],
            $attributes['street'],
            $attributes['number'],
            $attributes['complement'],
            $this->districtRepository->find($attributes['district'])
        );
    }

    private function createStudent(array $attributes, AddressInterface $address, ResponsibleInterface $responsible)
    {
        return  $this->studentRepository->create(
            $attributes['student_name'], 
            $attributes['birth_date'], 
            $attributes['student_identification_document'], 
            $attributes['mother_name'], 
            $attributes['mother_cpf'], 
            $attributes['brother'],
            $attributes['study_with_brother'], 
            $attributes['brother_name'], 
            $attributes['email'], 
            $attributes['phone'], 
            $attributes['legal_responsibility'], 
            $address,
            $responsible, 
            $attributes['bolsa_familia'], 
            $attributes['amount_residents'],
            $this->schoolRepository->find($attributes['school_first']),
            $this->schoolRepository->find($attributes['school_second']),
            $this->schoolRepository->find($attributes['school_third'])
        );
    }

    private function generateProtocol(ProcessInterface $process, StudentInterface $student)
    {
        $protocolo = $process->getType();
        $protocolo .= $process->getId();
        $protocolo .= date('Y');
        $protocolo .= $student->getId();

        return $protocolo;
    }

    private function createSubscription(array $attributes, StudentInterface $student){
        $process = $this->processRepository->find($attributes['process_id']);        
        $networkSchool = $attributes['network_school'] > 0 ? $this->schoolRepository->find($attributes['network_school']) : $this->schoolRepository->newEmptyInstance();        
        return  $this->subscriptionRepository->create(
            $student,
            $process,
            $networkSchool,
            $this->schoolGradeRepository->find($attributes['school_grade']),
            ProtocolGeneratorService::generate($process, $student)
        );
    }

    public function create(array $attributes)
    {
        $this->databaseManager->beginTransaction();
        try {            
            $responsible = $this->createResponsible($attributes);
            $address = $this->createAddres($attributes);
            $student = $this->createStudent($attributes, $address, $responsible);
            $subscription = $this->createSubscription($attributes, $student);

            $this->databaseManager->commit();

            return $subscription;
        } catch (\Exception $ex) {
            $this->databaseManager->rollback();
            throw $ex;
        }
    }

    public function confirmInformation(array $attributes)
    {
        $school_first = $this->schoolRepository->find($attributes['school_first']);
        $school_second = $this->schoolRepository->find($attributes['school_second']);
        $school_third = $this->schoolRepository->find($attributes['school_third']);
        
        $district = $this->districtRepository->find($attributes['district']);
        
        $attributes['school_first_name'] =  $school_first->name;
        $attributes['school_second_name'] =  $school_second->name;
        $attributes['school_third_name'] =  $school_third->name;
        $attributes['district_name'] =  $district->name;

        if(!isset($attributes['brother'])) $attributes['brother'] = 0;
        
        if(!isset($attributes['network_school'])){
            $attributes['network_school'] = 0;
            $attributes['network_school_name'] = 'N\A';
        } else {
            $network_school_name = $this->schoolRepository->find($attributes['network_school']);
            $attributes['network_school_name'] = $network_school_name->name;
        }

        $process = $this->processRepository->find($attributes['process_id']);
        $attributes['process_name'] = $process->name;

        $attributes['birth_date_br'] = Carbon::createFromFormat('Y-m-d', $attributes['birth_date'])->format('d/m/Y');

        return $attributes;
    }

    public function find($id)
    {   
        
        $subscription = $this->subscriptionRepository->find($id);
        
        $subscription = (object)array(
            'protocol' => $subscription->getProtocol(),
            'student' => (object)array(
                'legalResponsibility' => $subscription->getStudent()->isLegalResponsibility() == 0 ? 'Não' : 'Sim',
                'name' => $subscription->getStudent()->getName(),
                'birthDate' => date('d/m/Y', strtotime($subscription->getStudent()->getBirthDate())),
                'identificationDocument' => $subscription->getStudent()->getIdentificationDocument(),
                'motherName' => $subscription->getStudent()->getMotherName(),
                'motherCpf' => $subscription->getStudent()->getMotherCpf() ? $subscription->getStudent()->getMotherCpf() : 'Não informado',
                'email' => $subscription->getStudent()->getEmail() ? $subscription->getStudent()->getEmail() : 'Não informado',
                'phone' => $subscription->getStudent()->getPhone() ? $subscription->getStudent()->getPhone() : 'Não informado',
                'brother' => $subscription->getStudent()->isBrother() ? 'Sim' : 'Não',
                'studyWithBrother' => $subscription->getStudent()->getStudyWithBrother() == 0?  'Não' : 'Sim',
                'brotherName' => $subscription->getStudent()->getBrotherName() ? $subscription->getStudent()->getBrotherName() : 'Não informado',
                'amountResidents' => $subscription->getStudent()->getAmountResidents() ?  $subscription->getStudent()->getAmountResidents() : 'Não informado',
                'bolsaFamilia' => $subscription->getStudent()->hasBolsaFamilia() == 0 ? 'Não' : 'Sim',

                'address' => (object)array(
                    'city' => $subscription->getStudent()->getAddress()->getCity(),
                    'district' => $subscription->getStudent()->getAddress()->getDistrict()->getName(),
                    'city' => $subscription->getStudent()->getAddress()->getCity(),
                    'street' => $subscription->getStudent()->getAddress()->getStreet(),
                    'number' => $subscription->getStudent()->getAddress()->getNumber(),
                    'cep' => $subscription->getStudent()->getAddress()->getCep(),
                    'complement' => $subscription->getStudent()->getAddress()->getComplement() ? $subscription->getStudent()->getAddress()->getComplement() : 'Não informado',
                ),
            ),

            'responsible' => (object)array(
                'name' => $subscription->getStudent()->getResponsible()->getName(),
                'identificationDocument' => $subscription->getStudent()->getResponsible()->getIdentificationDocument(),
                
            ),
            'schoolFirst' => $subscription->getStudent()->getSchools()[0]->getName(),
            'schoolSecond' => $subscription->getStudent()->getSchools()[1]->getName(),
            'schoolThird' => $subscription->getStudent()->getSchools()[2]->getName(),
            'schoolGrade' => $subscription->getSchoolGrade()->getName(),
            'transfer' => $subscription->getNetworkSchool() ? 'Sim' : 'Não',
            'networkSchool' => $subscription->getNetworkSchool() ? $subscription->getNetworkSchool()->getName() : 'Não informado',
            'process' => (object)array(
                'observation' => $subscription->getProcess() ? $subscription->getProcess()->getObservation() : null,
            ),
        );

        return $subscription;
    }

    public function generateSpreadsheet(Filters $filters)
    {
        $subscriptions = $this->subscriptionRepository->findByFilter($filters, false);
        $this->buildSpreadsheet($subscriptions);
    }

    private function buildSpreadsheet($subscriptions)
    {
        $this->csvExporter->beforeEach(function ($subscription) {

            $subscription->transfer = $subscription->getNetworkSchool() ? 'Sim' : 'Não';
            $subscription->schoolFirst = $subscription->getStudent()->getSchools()[0]->getName();
            $subscription->schoolSecond = $subscription->getStudent()->getSchools()[1]->getName();
            $subscription->schoolThird = $subscription->getStudent()->getSchools()[2]->getName();
            
            $subscription->student->birth_date = date('d/m/Y', strtotime($subscription->getStudent()->getBirthDate()));
            $subscription->student->legal_responsibility = $subscription->getStudent()->isLegalResponsibility() ? 'Sim' : 'Não';
            $subscription->student->have_brother = $subscription->getStudent()->isBrother() ? 'Sim' : 'Não';
            $subscription->student->study_with_brother = $subscription->getStudent()->getStudyWithBrother() ? 'Sim' : 'Não';
            $subscription->student->amountResidents = $subscription->getStudent()->getAmountResidents() ?  $subscription->getStudent()->getAmountResidents() : 'Não informado';
            $subscription->student->bolsaFamilia = $subscription->getStudent()->hasBolsaFamilia() == 0 ? 'Não' : 'Sim';
        
        });
        
        $this->csvExporter->build($subscriptions, [
            'protocol' => 'Protocolo',
            'student.responsible.identification_document' => 'Documento do Responsável',
            'student.responsible.name' => 'Responsável',
            'student.legal_responsibility' => 'Responsável legal ?',
            'student.name' => 'Nome do dependente',
            'student.birth_date' => 'Data de nascimento',
            'student.identification_document' => 'Nº da Certidão de Nascimento',
            'student.mother_name' => 'Nome completo da mãe',
            'student.mother_cpf' => 'CPF da mãe',
            'student.email' => 'Email do responsável legal',
            'student.phone' => 'Telefone do responsável',
            'student.address.street' => 'Logradouro',
            'student.address.number' => 'Número',
            'student.address.complement' => 'Complemento',
            'student.address.cep' => 'CEP',
            'student.address.city' => 'Cidade',
            'student.address.district.name' => 'Bairro',
            'student.address.district.quadrant.name' => 'Quadrante',
            'student.have_brother' => 'O dependente possui irmão(s) gêmeo(s)? ',
            'student.study_with_brother' => 'Há interesse de que a criança estude na mesma escola do irmão ou da irmã?',
            'student.brother_name' => 'Nome do irmão/irmã',
            'schoolFirst' => 'Escola pretendida (primeira opção)',
            'schoolSecond' => 'Escola pretendida (segunda opção)',
            'schoolThird' => 'Escola pretendida (terceira opção)',
            'schoolGrade.name' => 'Série/Ano',
            'transfer' => 'É aluno da rede municipal solicitando transferência de escola?',
            'student.amountResidents' => 'Quantos moram na residência com a criança?',
            'student.bolsaFamilia' => 'Recebe bolsa família? ',
        ])->download("RELATORIO_INSCRICAO_".date('dmYHis').".csv");

    }


}

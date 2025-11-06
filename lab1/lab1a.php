<?php

enum Specialization: string
{
    case FAMILY_MEDICINE = "familyMedicine";
    case CARDIOLOGY = "cardiology";
    case NEUROLOGY = "neurology";
    case RADIOLOGY = "radiology";
}

trait Treatable {
    function diagnose(Patient $patient, string $diagnosis): void {
        $patient->medicalHistory[] = $diagnosis;
    }
}

class Patient
{
    public int $id;
    public string $name;
    public array $medicalHistory = [];
    public array $treatmentHistory = [];

    /**
     * @param int $id
     * @param string $name
     * @param $medicalHistory
     * @param $treatmentHistory
     */
    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function addMedicalHistory(string $diagnosis)
    {
        $this->medicalHistory[] = $diagnosis;
    }

    public function __toString(): string
    {
        return $this->id . " " . $this->name;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getMedicalHistory(): array
    {
        return $this->medicalHistory;
    }

    public function setMedicalHistory(array $medicalHistory): void
    {
        $this->medicalHistory = $medicalHistory;
    }

    public function getTreatmentHistory(): array
    {
        return $this->treatmentHistory;
    }

    public function setTreatmentHistory(array $treatmentHistory): void
    {
        $this->treatmentHistory = $treatmentHistory;
    }



}

class Doctor
{
    public string $id;
    public string $name;
    public Specialization $specialization;
    public int $yearsOfExperience;
    public array $patients = [];

    /**
     * @param string $id
     * @param string $name
     * @param Specialization $specialization
     * @param int $yearsOfExperience
     */
    public function __construct(string $id, string $name, int $yearsOfExperience, Specialization $specialization)
    {
        $this->id = $id;
        $this->name = $name;
        $this->specialization = $specialization;
        $this->yearsOfExperience = $yearsOfExperience;
    }

    public function getSpecialization(): Specialization
    {
        return $this->specialization;
    }

    public function setSpecialization(Specialization $specialization): void
    {
        $this->specialization = $specialization;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getYearsOfExperience(): int
    {
        return $this->yearsOfExperience;
    }

    public function setYearsOfExperience(int $yearsOfExperience): void
    {
        $this->yearsOfExperience = $yearsOfExperience;
    }

    public function getPatients(): array
    {
        return $this->patients;
    }

    public function setPatients(array $patients): void
    {
        $this->patients = $patients;
    }
    public function printPatients(): void
    {
        foreach ($this->getPatients() as $patient) {
            echo $patient . "\n";
        }
    }

}

class FamilyDoctor extends Doctor
{
    use Treatable;
    public function __construct(string $id, string $name, int $years)
    {
        parent::__construct($id, $name, $years, Specialization::FAMILY_MEDICINE);
    }

    function refer(Patient $patient, array $doctors, Specialization $specialization): Doctor
    {
        $doctors = array_filter($doctors, fn($d) => $d->getSpecialization() === $specialization);
        usort($doctors, fn($a, $b) => $b->getYearsOfExperience() <=> $a->getYearsOfExperience());
        $doctor = $doctors[0];
        $doctor->patients[] = $patient;
        return $doctor;
    }
    public function addPatient(Patient $john): void
    {
        $this->patients[] = $john;
    }



}


class Specialist extends Doctor
{
    public function __construct(string $id, string $name, int $years, Specialization $specialization)
    {
        parent::__construct($id, $name, $years, $specialization);
    }

    public function treatPatient(Patient $john, string $string)
    {
        $john->treatmentHistory[] = $string;
        $this->patients = array_filter($this->patients, fn($p) => $p !== $john);
    }
}

// Create patients
$john = new Patient(1, "John Doe");
$jane = new Patient(2, "Jane Smith");

// Create doctors
$familyDoctor = new FamilyDoctor("D001", "Dr. Brown", 12);
$cardiologist1 = new Specialist("D002", "Dr. Heart", 8, Specialization::CARDIOLOGY);
$cardiologist2 = new Specialist("D003", "Dr. Pulse", 15, Specialization::CARDIOLOGY);
$neurologist = new Specialist("D004", "Dr. Brain", 10, Specialization::NEUROLOGY);

// Add patient to family doctor
$familyDoctor->addPatient($john);
$familyDoctor->diagnose($john, 'High blood pressure');
// Print before referral
$familyDoctor->printPatients();

// Refer John to cardiologist (most experienced one)
$treatingDoctor = $familyDoctor->refer($john, [$cardiologist1, $cardiologist2, $neurologist], Specialization::CARDIOLOGY);
echo "Referred patient with id $john->id to doctor $treatingDoctor->name\n";

// Refer the same patient again (should return that patient is already referred)
$treatingDoctor = $familyDoctor->refer($john, [$cardiologist1, $cardiologist2, $neurologist], Specialization::CARDIOLOGY);

$treatingDoctor->printPatients();

if ($treatingDoctor instanceof Specialist) {
    $treatingDoctor->treatPatient($john, 'Beta-blockers');
}

// Print specialists’ patients after referral
$treatingDoctor->printPatients();

// Show John’s medical history
echo "\nMedical history of {$john->name}:\n";
foreach ($john->getMedicalHistory() as $record) {
    echo "- $record\n";
}
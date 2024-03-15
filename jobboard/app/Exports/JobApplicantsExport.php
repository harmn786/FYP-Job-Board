<?php
namespace App\Exports;
use App\Export\UsersExport;

use App\Models\JobApplication;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class JobApplicantsExport implements FromCollection,WithHeadings
{
    protected $jobApplications;

    public function __construct($jobApplications)
    {
        $this->jobApplications = $jobApplications;
    }

    public function collection()
    {

        return $this->jobApplications->map(function ($jobApplication) {
            return [
                'Name' => $jobApplication->jobSeeker->name,
                'Email' => $jobApplication->jobSeeker->email,
                'Education' => $jobApplication->jobSeeker->education,
                'Experience' => $jobApplication->jobSeeker->experience,
                'Skills' => $jobApplication->jobSeeker->skills,
                'Status' => $jobApplication->status,
                // Add more fields or related data as needed
            ];
        });
        // return $this->jobApplications;
    }
    public function headings(): array
    {
        return [
            'Name',
            'Email',
            'Education',
            'Experience',
            'Skills',
            'Status',
            // Add more headings as needed
        ];
    }
}
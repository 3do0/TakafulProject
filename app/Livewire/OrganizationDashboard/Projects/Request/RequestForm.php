<?php

namespace App\Livewire\OrganizationDashboard\Projects\Request;

use App\Models\OrganizationProjectRequest;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class RequestForm extends Component
{
    use WithFileUploads;

    public $organization_user_id;
    public $project_name;
    public $project_photo;
    public $project_file;
    public $beneficiaries_count;
    public $description;
    public $location;
    public $contact_number;
    public $whatsapp_number;

    protected $rules = [
        'project_name'         => 'required|string|max:100',
        'project_photo'        => 'required|image|mimes:jpeg,png,jpg,gif|max:16000',
        'project_file'         => 'required|mimes:pdf|max:10000',
        'beneficiaries_count'  => 'required|integer|min:1',
        'description'          => 'nullable|string|max:1000',
        'location'             => 'required|string|max:255',
        'contact_number'       => ['required', 'regex:/^7[0-9]{8}$/'],
        'whatsapp_number'      => ['required', 'regex:/^7[0-9]{8}$/'],
    ];
    

    public function AddRequest()
    {
        // dd( $this->organization_id);
        $this->validate();

        $photoPath = null;
        if ($this->project_photo) {
            $photoName = $this->project_photo->hashName();
            $photoPath = $this->project_photo->storeAs('projectsPhotos', $photoName, 'public');
        }
        $FilePath = null;
        if ($this->project_file) {
            $pdfname = $this->project_file->hashName();
            $FilePath = $this->project_file->storeAs('projectsFiles', $pdfname, 'public');
        }

        try {
            $project = OrganizationProjectRequest::create([
                'organization_user_id' => $this->organization_user_id,
                'project_name' => $this->project_name,
                'project_photo' => $photoPath,
                'project_file' => $FilePath,
                'beneficiaries_count' => $this->beneficiaries_count,
                'description' => $this->description,
                'location' => $this->location,
                'contact_number' => $this->contact_number,
                'whatsapp_number' => $this->whatsapp_number,
            ]);

            $this->reset();
            $this->SetOrganizationUserId();

            $this->dispatch('swal:toast', [
                'icon' => 'success',
                'title' => 'تمت إضافة الطلب بنجاح',
            ]);
        } catch (\Exception $e) {
            $this->dispatch('swal:toast', [
            'icon' => 'error',
            'title' => 'حدث خطأ ما'. $e->getMessage(),
        ]);
        }
    }

    public function mount()
    {
        $this->SetOrganizationUserId();
    }

    public function SetOrganizationUserId()
    {
        if (auth('organization')->check()) {
            $this->organization_user_id = auth('organization')->user()->id;
        }
    }
    public function render()
    {
        return view('livewire.organization-dashboard.projects.request.request-form')->layout('layouts.Organization_Dashboard.app');
    }
}

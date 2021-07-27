<?php

namespace App\Http\Livewire;

use App\Models\Project;
use Livewire\Component;

class Projects extends Component
{
    public $project;
    public $projectId;

    public $searchTerm;
    public $messageText = '';
    public $alert = '';

    public $showForm = false;

    public $quickView = false;

    protected $rules = [
        'project.title' => 'required|string|max:100|min:3',
        'project.description' => 'required|string|max:1000|min:3',
    ];


    public function render()
    {
        $searchTerm = '%'.$this->searchTerm. '%';
        $projects = Project::where('user_id', auth()->id())
                                ->where('title', 'LIKE', $searchTerm)
                                ->orWhere('description', 'LIKE', $searchTerm)
                                ->latest()
                                ->paginate(10);

        return view('livewire.projects', compact('projects'));
    }

    public function updated($key, $value)
    {
        $this->validateOnly($key);
    }

    public function create()
    {
        $this->showForm = true;
        $this->project = null;
        $this->projectId = null;
    }

    public function save()
    {
        $this->validate();
    }

    public function view($projectId)
    {
        $this->quickView = true;
        $this->projectId = $projectId;
        $this->project = Project::find($projectId);
    }

    public function closeAlert()
    {
        $this->messageText = '';
        $this->alert = '';
    }

    public function close()
    {
        $this->showForm = false;
        $this->quickView = false;
    }
}

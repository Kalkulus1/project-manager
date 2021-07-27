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
        'project.title' => 'required|string|max:255|min:3',
        'project.description' => 'required|string|max:1000|min:3',
        'project.status' => 'nullable|min:3',
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

    public function edit($projectId)
    {
        $this->quickView = false;
        $this->showForm = true;
        $this->projectId = $projectId;
        $this->project = Project::find($projectId);
    }

    public function save()
    {
        $this->validate();

        if (!is_null($this->projectId)) {
            $this->project->save();
            $this->messageText = 'Project '. $this->project->title . ' is updated';
            $this->alert = 'success';
        } else {
            $project = new Project;
            $project->title = $this->project['title'];
            $project->description = $this->project['description'];
            $project->user_id = auth()->id();
            $project->save();
            $this->messageText = 'New Project Added';
            $this->alert = 'success';
        }
        $this->showForm = false;
        $this->project = '';
    }

    public function view($projectId)
    {
        $this->quickView = true;
        $this->projectId = $projectId;
        $this->project = Project::find($projectId);
    }

    public function status()
    {
        $project = Project::find($this->projectId);
        $project->status = $this->project['status'];
        $project->save();
        $this->messageText = 'Project '. $project->title . ' status was updated';
        $this->alert = 'success';
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

    public function delete($projectId)
    {
        $this->quickView = false;
        $this->showForm = false;
        $this->project = Project::find($projectId);
        if ($this->project) {
            $this->project->delete();

            $this->messageText = 'Project deleted successfully';
            $this->alert = 'warning';
        } else{
            $this->messageText = 'Could not delete project!';
            $this->alert = 'danger';
        }
    }
}

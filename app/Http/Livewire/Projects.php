<?php

namespace App\Http\Livewire;

use App\Models\Project;
use App\Models\Task;
use Livewire\Component;

class Projects extends Component
{
    public $project;
    public $projectId;

    public $task;
    public $taskId;

    public $searchTerm;
    public $messageText = '';
    public $alert = '';

    public $showForm = false;
    public $quickView = false;
    public $tasksView = false;
    public $taskForm = false;

    protected $rules = [
        'project.title' => 'required|string|max:255|min:3',
        'project.description' => 'required|string|max:1000|min:3',
        'project.status' => 'nullable|min:3',
        'task.title' => 'nullable|string|max:255|min:3',
        'task.status' => 'nullable|min:3',
    ];


    public function render()
    {
        $searchTerm = '%'.$this->searchTerm. '%';
        $projects = Project::where('user_id', auth()->id())
                                ->where('title', 'LIKE', $searchTerm)
                                ->orWhere('description', 'LIKE', $searchTerm)
                                ->orWhere('status', 'LIKE', $searchTerm)
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

        $this->tasksView = false;
        $this->quickView = false;
    }

    public function edit($projectId)
    {
        $this->tasksView = false;
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
        $this->tasksView = false;
        $this->showForm = false;
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
        $this->tasksView = false;
        $this->taskForm = false;
    }

    public function delete($projectId)
    {
        $this->quickView = false;
        $this->showForm = false;
        $this->tasksView = false;
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

    public function tasks($projectId)
    {
        $this->quickView = false;
        $this->showForm = false;
        $this->tasksView = true;

        $this->projectId = $projectId;
        $this->project = Project::find($projectId);
    }

    public function addTask()
    {
        $this->quickView = false;
        $this->showForm = false;

        $this->taskForm = true;
        $this->task = null;
        $this->taskId = null;
    }

    public function saveTask()
    {
        if (!is_null($this->taskId)) {
            $this->task->save();
            $this->messageText = 'Task '. $this->task->title . ' is updated';
            $this->alert = 'success';
        } else {
            $task = new Task;
            $task->title = $this->task['title'];
            $task->project_id = $this->projectId;
            $task->save();
            $this->messageText = 'New Task Added';
            $this->alert = 'success';
        }
        $this->taskForm = false;
        $this->task = '';
    }

    public function editTask($taskId)
    {
        $this->quickView = false;
        $this->showForm = false;

        $this->taskForm = true;
        $this->taskId = $taskId;
        $this->task = Task::find($taskId);
    }

    public function taskStatus($taskId)
    {
        $task = Task::find($taskId);
        $task->status = $this->task['status'];
        $task->save();
        $this->messageText = 'Task '. $task->title . ' status was updated';
        $this->alert = 'success';
    }

    public function deleteTask($taskId)
    {
        $this->quickView = false;
        $this->showForm = false;
        $this->tasksView = false;
        $this->taskForm = false;
        $this->task = Task::find($taskId);
        if ($this->task) {
            $this->task->delete();

            $this->messageText = 'Task deleted successfully';
            $this->alert = 'warning';
        } else{
            $this->messageText = 'Could not delete task!';
            $this->alert = 'danger';
        }
    }
}

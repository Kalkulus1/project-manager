<div class="row justify-content-center">
    <div class="@if ($quickView) col-md-8 @else col-md-12 @endif">
        <div class="card">
            <div class="card-header">
                <a wire:click.prevent="create" href="#" class="btn btn-sm btn-primary">Add A Project</a>
                <input type="text" class="form-control pull-right col-md-3 mt-2" placeholder="Search project..." wire:model="searchTerm">
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    @if ($messageText != '')
                    <div class="alert alert-{{ $alert }} alert-dismissible">
                        <button wire:click="closeAlert" type="button" class="btn-close btn-sm btn-{{ $alert }}" data-bs-dismiss="alert" aria-label="Close">X</button>
                        {{ $messageText }}
                    </div>
                    @endif
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Updated</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($projects as $item)
                                <tr>
                                    <td>{{ $item->title }}</td>

                                    @if ($item->status == "Started")
                                    <td class="badge badge-dark">{{ $item->status }}</td>
                                    @endif

                                    @if ($item->status == "In-progress")
                                    <td class="badge badge-warning">{{ $item->status }}</td>
                                    @endif

                                    @if ($item->status == "Completed")
                                    <td class="badge badge-success">{{ $item->status }}</td>
                                    @endif

                                    <td>{{ $item->created_at }}</td>
                                    <td>{{ $item->updated_at }}</td>
                                    <td>
                                        <a wire:click.prevent="view({{ $item->id }})" href="#" class="btn btn-sm btn-outline-primary mb-2">Quick View</a>
                                        <a wire:click.prevent="edit({{ $item->id }})" href="#" class="btn btn-sm btn-outline-success mb-2">Edit</a>
                                        <a wire:click.prevent="delete({{ $item->id }})" onclick="confirm('Are you sure {{ $item->title }}?') || event.stopImmediatePropagation()" href="#" class="btn btn-sm btn-outline-danger mb-2">Delete</a>
                                        <a href="" class="btn btn-sm btn-outline-dark mb-2">Add Tasks (5)</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $projects->render("pagination::bootstrap-4") }}
                </div>
            </div>
        </div>
    </div>
    @if ($quickView)
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">{{ $project->title }} <button wire:click="close" type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button></div>
                <div class="card-body">
                    Status:
                    @if ($project->status == "Started")
                    <h3 class="badge badge-dark">{{ $item->status }}</h3>
                    @endif

                    @if ($project->status == "In-progress")
                    <h3 class="badge badge-warning">{{ $item->status }}</h3>
                    @endif

                    @if ($project->status == "Completed")
                    <h3 class="badge badge-success">{{ $item->status }}</h3>
                    @endif
                    <p>
                        <form wire:click.prevent="status">
                            <div class="form-group">
                                <label for="project.title" class="col-form-label">
                                    Change Project Status
                                </label>
                                <select wire:model="project.status" class="form-control @error('project.status') is-invalid @enderror">
                                    <option value="Started">Started</option>
                                    <option value="In-progress">In-progress</option>
                                    <option value="Completed">Completed</option>
                                </select>
                                @error('project.status')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </form>
                    </p>
                    <h5>Description</h5>
                    <p>
                        {!! $project->description !!}
                    </p>
                </div>
            </div>
        </div>
    @endif

    <div class="modal" class="modal fade" @if ($showForm) style="display:block" @endif>
        <div class="modal-dialog">
            <div class="modal-content">
                <form wire:submit.prevent="save">
                    <div class="modal-header">
                        <h5 class="modal-title">{{ $projectId ? 'Edit Project' : 'Add New Project' }}</h5>
                        <button wire:click="close" type="button" class="btn-close btn-sm btn-dark" data-bs-dismiss="modal" aria-label="Close">X</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="project.title" class="col-form-label">
                                Title
                            </label>
                            <input wire:model="project.title" type="text"
                                   class="form-control @error('project.title') is-invalid @enderror"/>
                            @error('project.title')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="project.description" class="col-form-label">
                                Description
                            </label>
                            <textarea cols="5" rows="5" wire:model="project.description"
                            class="form-control @error('project.description') is-invalid @enderror"></textarea>
                            @error('project.description')
                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{ $projectId ? 'Save Changes' : 'Save' }}</button>
                        <button wire:click="close" type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

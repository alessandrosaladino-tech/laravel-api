@extends('layouts.admin')

@section('content')
    <div class="container">
        <h2 class="fs-4 text-secondary my-4">
            {{ __('Project Edit Page for') }} {{ Auth::user()->name }}.
        </h2>
        <h3 class="fs-5 text-secondary">
            {{ __('Editing Project') }} ID: {{ $project->id }}
        </h3>

        <div class="row justify-content-center my-3">
            <div class="col">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.projects.update', $project) }}" method="POST" enctype="multipart/form-data">

                    @csrf

                    @method('PUT')

                    <div class="mb-3">

                        <label for="title" class="form-label"><strong>Title</strong></label>

                        <input type="text" class="form-control" name="title" id="title"
                            aria-describedby="helpTitle" value="{{ old('title') ? old('title') : $project->title }}">

                        @error('title')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror

                    </div>

                    <div class="mb-3">
                        <label for="type_id" class="form-label"><strong>Type</strong></label>
                        <select class="form-select form-select @error('type_id') is-invalid @enderror" name="type_id"
                            aria-describedby="helpType_id" id="type_id">
                            <option selected disabled>Select a Type</option>
                            <option value="">Untyped</option>
                            @foreach ($types as $type)
                                <option value="{{ $type->id }}" 
                                    {{ $type->id == old('type_id', $project->type_id) ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('type_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="my-4">
                        <label for="type_id" class="form-label d-block"><strong>Choose Technologies</strong></label>
                        @foreach ($technologies as $technology)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="technologies[]" name="technologies[]"
                                    value="{{ $technology->id }}"
                                    {{ in_array($technology->id, old('technologies', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="technologies[]">{{ $technology->name }}</label>
                            </div>
                        @endforeach
                    </div>

                    <div class="mb-3">

                        <label for="description" class="form-label"><strong>Description</strong></label>

                        <input type="text" class="form-control" name="description" id="description"
                            aria-describedby="helpDescription"
                            value="{{ old('description') ? old('description') : $project->description }}">

                        @error('description')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>


                    <div class="mb-3">

                        <label for="tech" class="form-label"><strong>GitHub Link</strong></label>

                        <input type="text" class="form-control" name="github_link" id="github_link"
                            aria-describedby="helpGitLink" value="{{ old('github_link') ? old('github_link') : $project->github_link }}">

                        @error('tech')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">

                        <label for="public_link" class="form-label"><strong>Published Project Link</strong></label>

                        <input type="text" class="form-control" name="public_link" id="public_link"
                            aria-describedby="helpPubliLink" value="{{ old('public_link') ? old('public_link') : $project->public_link }}">

                        @error('public_link')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">

                        <label for="release_date" class="form-label"><strong>Release Date</strong></label>

                        <input type="text" class="form-control" name="release_date" id="release_date"
                            aria-describedby="helpPubliLink" value="{{ old('release_date') ? old('release_date') : $project->release_date }}">

                        @error('release_date')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">

                        <div class="mb-3">

                            @if (str_contains($project->thumb, 'http'))
                                <td><img class=" img-fluid" style="height: 100px" src="{{ $project->thumb }}"
                                        alt="{{ $project->title }}"></td>
                            @else
                                <td><img class=" img-fluid" style="height: 100px"
                                        src="{{ asset('storage/' . $project->thumb) }}"></td>
                            @endif

                        </div>

                        <label for="thumb" class="form-label"><strong>Choose a Thumbnail image file</strong></label>

                        <input type="file" class="form-control" name="thumb" id="thumb" placeholder="Cerca..."
                            aria-describedby="fileHelpThumb">

                        @error('thumb')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror

                    </div>

                    <button type="submit" class="btn btn-success my-3">SAVE</button>
                    <a class="btn btn-primary" href="{{ route('admin.projects.index') }}">CANCEL</a>

                </form>
            </div>
        </div>

    </div>
@endsection
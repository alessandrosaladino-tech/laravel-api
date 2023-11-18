@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1 class="fs-4 text-secondary my-4">
            {{ __('Project List for') }} {{ Auth::user()->name }}
        </h1>

        @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                {{ session('status') }}
            </div>
        @endif

        <a href="{{ route('admin.projects.create') }}" class="btn btn-outline-danger my-3">Add a New Project</a>

        <div class="pt-4"> {{$projects->links('pagination::bootstrap-5')}} </div>

        <div class="table-responsive">
            <table class="table table-secondary table-hover table-striped table-bordered">
                <thead class="table-group-divider text-center">
                        <tr class="table-danger">
                            <th scope="col">ID</th>
                            <th scope="col">Preview</th>
                            <th scope="col">Title</th>
                            <th scope="col">Release Date</th>
                            <th scope="col">Links</th>
                            <th scope="col">Actions</th>
                        </tr>
                </thead>
                <tbody class="text-center">
                        @forelse ($projects as $project)
                            <tr class="table-secondary">
                                <td class="align-middle" scope="row">{{ $project->id }}</td>

                                @if (str_contains($project->thumb, 'http'))
                                    <td class="text-center align-middle"><img class="img-fluid" style="height: 100px"
                                            src="{{ $project->thumb }}" alt="{{ $project->title }}"></td>
                                @else
                                    <td class="text-center align-middle"><img class="img-fluid" style="height: 100px"
                                            src="{{ asset('storage/' . $project->thumb) }}"></td>
                                @endif


                                <td class="align-middle">{{ $project->title }}</td>
                                <td class="align-middle">{{ $project->release_date }}</td>
                                <td class="align-middle">

                                    <a class="text-black gap-1" href="{{ $project->github_link }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="2em" viewBox="0 0 448 512">
                                            <style>
                                                svg {
                                                    fill: #000000
                                                }
                                            </style>
                                            <path
                                                d="M400 32H48C21.5 32 0 53.5 0 80v352c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V80c0-26.5-21.5-48-48-48zM277.3 415.7c-8.4 1.5-11.5-3.7-11.5-8 0-5.4.2-33 .2-55.3 0-15.6-5.2-25.5-11.3-30.7 37-4.1 76-9.2 76-73.1 0-18.2-6.5-27.3-17.1-39 1.7-4.3 7.4-22-1.7-45-13.9-4.3-45.7 17.9-45.7 17.9-13.2-3.7-27.5-5.6-41.6-5.6-14.1 0-28.4 1.9-41.6 5.6 0 0-31.8-22.2-45.7-17.9-9.1 22.9-3.5 40.6-1.7 45-10.6 11.7-15.6 20.8-15.6 39 0 63.6 37.3 69 74.3 73.1-4.8 4.3-9.1 11.7-10.6 22.3-9.5 4.3-33.8 11.7-48.3-13.9-9.1-15.8-25.5-17.1-25.5-17.1-16.2-.2-1.1 10.2-1.1 10.2 10.8 5 18.4 24.2 18.4 24.2 9.7 29.7 56.1 19.7 56.1 19.7 0 13.9.2 36.5.2 40.6 0 4.3-3 9.5-11.5 8-66-22.1-112.2-84.9-112.2-158.3 0-91.8 70.2-161.5 162-161.5S388 165.6 388 257.4c.1 73.4-44.7 136.3-110.7 158.3zm-98.1-61.1c-1.9.4-3.7-.4-3.9-1.7-.2-1.5 1.1-2.8 3-3.2 1.9-.2 3.7.6 3.9 1.9.3 1.3-1 2.6-3 3zm-9.5-.9c0 1.3-1.5 2.4-3.5 2.4-2.2.2-3.7-.9-3.7-2.4 0-1.3 1.5-2.4 3.5-2.4 1.9-.2 3.7.9 3.7 2.4zm-13.7-1.1c-.4 1.3-2.4 1.9-4.1 1.3-1.9-.4-3.2-1.9-2.8-3.2.4-1.3 2.4-1.9 4.1-1.5 2 .6 3.3 2.1 2.8 3.4zm-12.3-5.4c-.9 1.1-2.8.9-4.3-.6-1.5-1.3-1.9-3.2-.9-4.1.9-1.1 2.8-.9 4.3.6 1.3 1.3 1.8 3.3.9 4.1zm-9.1-9.1c-.9.6-2.6 0-3.7-1.5s-1.1-3.2 0-3.9c1.1-.9 2.8-.2 3.7 1.3 1.1 1.5 1.1 3.3 0 4.1zm-6.5-9.7c-.9.9-2.4.4-3.5-.6-1.1-1.3-1.3-2.8-.4-3.5.9-.9 2.4-.4 3.5.6 1.1 1.3 1.3 2.8.4 3.5zm-6.7-7.4c-.4.9-1.7 1.1-2.8.4-1.3-.6-1.9-1.7-1.5-2.6.4-.6 1.5-.9 2.8-.4 1.3.7 1.9 1.8 1.5 2.6z" />
                                        </svg></a>

                                    <a class="text-black" href="{{ $project->public_link }}"><svg
                                            xmlns="http://www.w3.org/2000/svg"  height="2em"
                                            fill="currentColor" class="bi bi-link-45deg" viewBox="0 0 16 16">
                                            <path
                                                d="M4.715 6.542 3.343 7.914a3 3 0 1 0 4.243 4.243l1.828-1.829A3 3 0 0 0 8.586 5.5L8 6.086a1.002 1.002 0 0 0-.154.199 2 2 0 0 1 .861 3.337L6.88 11.45a2 2 0 1 1-2.83-2.83l.793-.792a4.018 4.018 0 0 1-.128-1.287z" />
                                            <path
                                                d="M6.586 4.672A3 3 0 0 0 7.414 9.5l.775-.776a2 2 0 0 1-.896-3.346L9.12 3.55a2 2 0 1 1 2.83 2.83l-.793.792c.112.42.155.855.128 1.287l1.372-1.372a3 3 0 1 0-4.243-4.243L6.586 4.672z" />
                                        </svg></a>

                                </td>
                                <td class="align-middle">
                                    <div class="col d-flex align-items-center justify-content-center gap-2">
                                        <a href="{{ route('admin.projects.edit', $project->slug) }}"
                                            style="height: 40px; width:40px" class="btn btn-outline-success  d-flex">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="" viewBox="0 0 512 512">
                                                <style>
                                                    svg {
                                                        fill: #000000
                                                    }
                                                </style>
                                                <path
                                                    d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin.projects.show', $project->slug) }}"
                                            style="height: 40px; width:40px" class="btn btn-outline-warning btn-sm d-flex">
                                            <svg xmlns="http://www.w3.org/2000/svg" style="" viewBox="0 0 512 512">
                                                <style>
                                                    svg {
                                                        fill: #000000
                                                    }
                                                </style>
                                                <path
                                                    d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z" />
                                            </svg>
                                        </a>


                                        <!-- Modal trigger button -->
                                        <button type="button" style="height: 40px; width:40px"
                                            class="btn btn-outline-danger btn-sm d-flex p-2" data-bs-toggle="modal"
                                            data-bs-target="#modalId-{{ $project->id }}">
                                            <svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 512 512">
                                                <style>
                                                    svg {
                                                        fill: #000000
                                                    }
                                                </style>
                                                <path
                                                    d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z" />
                                            </svg>
                                        </button>
                                    </div>

                                    <!-- Modal Body -->
                                    <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
                                    <div class="modal fade" id="modalId-{{ $project->id }}" tabindex="-1"
                                        data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
                                        aria-labelledby="modalTitleId-{{ $project->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-sm"
                                            role="document">

                                            <div class="modal-content">

                                                <div class="modal-header">
                                                    <h5 class="modal-title d-flex justify-content-center align-items-center gap-3 w-100"
                                                        id="modalTitleId-{{ $project->id }}">
                                                        <i class="fa-solid fa-triangle-exclamation text-warning"></i>
                                                        Warning <i
                                                            class="fa-solid fa-triangle-exclamation text-warning"></i>
                                                    </h5>
                                                </div>
                                                {{-- /.modal-header --}}

                                                <div class="modal-body text-center">
                                                    Are you sure you want to delete?
                                                </div>
                                                {{-- /.modal-body --}}

                                                <div
                                                    class="modal-footer d-flex justify-content-center align-items-center gap-3">

                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>

                                                    <form action="{{ route('admin.projects.destroy', $project->slug) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </form>

                                                </div>
                                                {{-- /.modal-footer --}}

                                            </div>
                                            {{-- /.modal-content --}}

                                        </div>
                                        {{-- /.modal-dialog --}}
                                    </div>
                                    {{-- /.modal --}}
                                </td>
                            </tr>
                        @empty
                            <td class="align-middle text-center" colspan="6">No Projects to show</td>
                        @endforelse
                    
                </tbody>
            </table>
        </div>

    </div>
@endsection

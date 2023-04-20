@extends('layouts.app')

@section('actions')
    <div class="container mt-4 mb-3">
        <a class="btn btn-primary" href="{{ route('admin.projects.index') }}"> <i class="fa-solid fa-eye text-white me-2"></i>
            See all Projects</a>
    </div>
@endsection
@section('content')
    <div class="container">
        <div class="mb-4 mt-4 d-flex align-items-center">
            <i class="fa-solid fa-trash-can text-primary me-3 fs-1"></i>
            <h1 class="mb-0">Projects Trashcan</h1>
        </div>
        <table class="table">
            <thead>
                <tr>
                    {{-- ID --}}
                    <th scope="col">
                        <a {{-- Operatore ternario per gestire SORT&ORDER --}}
                            href="{{ route('admin.projects.trash') }}?sort=id&order={{ $sort == 'id' && $order != 'DESC' ? 'DESC' : 'ASC' }}">Id</a>

                        @if ($sort == 'id')
                            {{-- se si sceglie di gestire a partire dall'id quindi sort=id appare la freccia e cambia rotazione se ascendente o discendente --}}
                            <a
                                href="{{ route('admin.projects.trash') }}?sort=id&order={{ $sort == 'id' && $order != 'DESC' ? 'DESC' : 'ASC' }}">
                                <i
                                    class="fa-solid fa-caret-down ms-2 @if ($order == 'DESC') rotate-180 @endif"></i></a>
                        @endif
                    </th>
                    {{-- IMG
                    <th scope="col"><a
                            href="{{ route('admin.projects.trash') }}?sort=title&order={{ $sort == 'title' && $order != 'DESC' ? 'DESC' : 'ASC' }}">Preview</a>

                        @if ($sort == 'title')
                            <a
                                href="{{ route('admin.projects.trash') }}?sort=title&order={{ $sort == 'title' && $order != 'DESC' ? 'DESC' : 'ASC' }}"><i
                                    class="fa-solid fa-caret-down ms-2 @if ($order == 'DESC') rotate-180 @endif"></i></a>
                        @endif
                    </th> --}}
                    {{-- TITLE --}}
                    <th scope="col"><a
                            href="{{ route('admin.projects.trash') }}?sort=title&order={{ $sort == 'title' && $order != 'DESC' ? 'DESC' : 'ASC' }}">Title</a>

                        @if ($sort == 'title')
                            <a
                                href="{{ route('admin.projects.trash') }}?sort=title&order={{ $sort == 'title' && $order != 'DESC' ? 'DESC' : 'ASC' }}"><i
                                    class="fa-solid fa-caret-down ms-2 @if ($order == 'DESC') rotate-180 @endif"></i></a>
                        @endif
                    </th>
                    {{-- TECHONOLOGIES --}}
                    <th scope="col"><a
                            href="{{ route('admin.projects.trash') }}?sort=title&order={{ $sort == 'title' && $order != 'DESC' ? 'DESC' : 'ASC' }}">Techs</a>

                        @if ($sort == 'title')
                            <a
                                href="{{ route('admin.projects.trash') }}?sort=title&order={{ $sort == 'title' && $order != 'DESC' ? 'DESC' : 'ASC' }}"><i
                                    class="fa-solid fa-caret-down ms-2 @if ($order == 'DESC') rotate-180 @endif"></i></a>
                        @endif
                    </th>
                    {{-- TYPE --}}
                    <th scope="col">
                        <a
                            href="{{ route('admin.projects.trash') }}?sort=type_id&order={{ $sort == 'type_id' && $order != 'desc' ? 'desc' : 'asc' }}">
                            Type
                            @if ($sort == 'type_id')
                                <i
                                    class="bi bi-caret-down-fill d-inline-block @if ($order == 'desc') rotate-180 @endif"></i>
                            @endif
                        </a>
                    </th>
                    {{-- TEXT --}}
                    <th scope="col"><a
                            href="{{ route('admin.projects.trash') }}?sort=text&order={{ $sort == 'text' && $order != 'DESC' ? 'DESC' : 'ASC' }}">Abstract</a>

                        @if ($sort == 'text')
                            <a
                                href="{{ route('admin.projects.trash') }}?sort=text&order={{ $sort == 'text' && $order != 'DESC' ? 'DESC' : 'ASC' }}"><i
                                    class="fa-solid fa-caret-down ms-2 @if ($order == 'DESC') rotate-180 @endif"></i></a>
                        @endif
                    </th>
                    {{-- CREATED --}}
                    <th scope="col">
                        <a
                            href="{{ route('admin.projects.trash') }}?sort=created_at&order={{ $sort == 'created_at' && $order != 'DESC' ? 'DESC' : 'ASC' }}">Created</a>

                        @if ($sort == 'created_at')
                            <a
                                href="{{ route('admin.projects.trash') }}?sort=created_at&order={{ $sort == 'created_at' && $order != 'DESC' ? 'DESC' : 'ASC' }}"><i
                                    class="fa-solid fa-caret-down ms-2 @if ($order == 'DESC') rotate-180 @endif"></i></a>
                        @endif
                    </th>
                    {{-- UPDATED --}}
                    <th scope="col">
                        <a
                            href="{{ route('admin.projects.trash') }}?sort=updated_at&order={{ $sort == 'updated_at' && $order != 'DESC' ? 'DESC' : 'ASC' }}">Updated</a>

                        @if ($sort == 'updated_at')
                            <a
                                href="{{ route('admin.projects.trash') }}?sort=updated_at&order={{ $sort == 'updated_at' && $order != 'DESC' ? 'DESC' : 'ASC' }}"><i
                                    class="fa-solid fa-caret-down ms-2 @if ($order == 'DESC') rotate-180 @endif"></i></a>
                        @endif
                    </th>
                    {{-- DELETED --}}
                    <th scope="col">
                        <a
                            href="{{ route('admin.projects.trash') }}?sort=updated_at&order={{ $sort == 'updated_at' && $order != 'DESC' ? 'DESC' : 'ASC' }}">Deleted</a>

                        @if ($sort == 'updated_at')
                            <a
                                href="{{ route('admin.projects.trash') }}?sort=updated_at&order={{ $sort == 'updated_at' && $order != 'DESC' ? 'DESC' : 'ASC' }}"><i
                                    class="fa-solid fa-caret-down ms-2 @if ($order == 'DESC') rotate-180 @endif"></i></a>
                        @endif
                    </th>

                    <th scope="col">Actions</th>
                </tr>
            </thead>
            {{-- BODY --}}
            <tbody>
                @forelse ($projects as $project)
                    <tr>
                        <th scope="row">{{ $project->id }}</th>
                        {{-- <td>
                            <div class="image-prev-index border p-2 d-flex align-items-center">
                                <img src="{{ $project->getImageUri() }}" alt="{{ $project->title }}" id="image-prev-i">
                            </div>
                        </td> --}}
                        <td>{{ $project->title }}</td>
                        <td>
                            @forelse($project->technologies as $technology)
                                <p class="fw-light fs-6">{{ $technology->label }}</p>
                            @empty
                                <span>-</span>
                            @endforelse
                        </td>
                        <td>
                            <span class="badge rounded-pill" style="background-color: {{ $project->type?->color }}">
                                {{ $project->type?->label }}
                            </span>
                            {{-- @dump($project->type) --}}
                        </td>
                        <td>{{ $project->getAbstract() }}</td>
                        <td>{{ $project->created_at }}</td>
                        <td>{{ $project->getUpdatedAttribute() }}</td>
                        <td>{{ $project->deleted_at }}</td>
                        <td>
                            {{-- <a href="{{ route('admin.projects.show', $project) }}"><i class="fa-solid fa-eye"></i></a> --}}
                            <button class="ms-3 text-danger" data-bs-toggle="modal"
                                data-bs-target="#delete-modal-{{ $project->id }}" title="Elimina il prodotto"><i
                                    class="fa-solid fa-trash"></i>
                            </button>
                            <button class="ms-3 text-success" data-bs-toggle="modal"
                                data-bs-target="#restore-modal-{{ $project->id }}" title="Ripristina il prodotto"> <i
                                    class="fa-solid fa-arrow-up-from-bracket"></i>
                            </button>
                        </td>
                    </tr>

                @empty
                    <h4>The trashcan is empty.</h4>
                @endforelse

            </tbody>
        </table>
        {{-- PAGINATION --}}
        {{ $projects->links() }}
    </div>

    {{-- MODALE --}}
    @foreach ($projects as $project)
        <!-- Modal -->
        <div class="modal fade" id="delete-modal-{{ $project->id }}" tabindex="-1" data-bs-backdrop="static"
            aria-labelledby="delete-modal-{{ $project->id }}-label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="delete-modal-{{ $project->id }}-label">Conferma eliminazione</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-start">
                        Sei sicuro di voler eliminare definitivamente il progetto <strong>{{ $project->title }}</strong>
                        con ID
                        <strong> {{ $project->id }}</strong>? <br>
                        L'operazione <strong>non è reversibile!</strong>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>

                        <form action="{{ route('admin.projects.force-delete', $project) }}" method="POST" class="">
                            @method('delete')
                            @csrf

                            <button type="submit" class="btn btn-danger">Elimina</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- Modale ripristino --}}
        <div class="modal fade" id="restore-modal-{{ $project->id }}" tabindex="-1" data-bs-backdrop="static"
            aria-labelledby="restore-modal-{{ $project->id }}-label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="delete-modal-{{ $project->id }}-label">Conferma Ripristino</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-start">
                        Sei sicuro di voler ripristinare il progetto <strong>{{ $project->title }}</strong> con ID
                        <strong> {{ $project->id }}</strong>?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>

                        <form action="{{ route('admin.projects.restore', $project->id) }}" method="POST"
                            class="">
                            @method('put')
                            @csrf

                            <button type="submit" class="btn btn-success">Ripristina</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

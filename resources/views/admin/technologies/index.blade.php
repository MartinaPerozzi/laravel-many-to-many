@extends('layouts.app')

@section('actions')
    <div class="container mt-4 mb-3">
        <a class="btn btn-primary" href="{{ route('admin.technologies.create') }}"><i
                class="fa-solid fa-plus text-white me-2"></i>Add a Tech
            Lab</a>
        {{-- <a class="btn btn-primary" href="{{ route('admin.projects.trash') }}">Trashcan</a> --}}

    </div>
@endsection
@section('content')
    <div class="container">
        <h1 class="mb-3">Techs</h1>
        <table class="table">
            <thead>
                <tr>
                    {{-- ID --}}
                    <th scope="col">
                        <a {{-- Operatore ternario per gestire SORT&ORDER --}}
                            href="{{ route('admin.technologies.index') }}?sort=id&order={{ $sort == 'id' && $order != 'DESC' ? 'DESC' : 'ASC' }}">Id</a>

                        @if ($sort == 'id')
                            {{-- se si sceglie di gestire a partire dall'id quindi sort=id appare la freccia e cambia rotazione se ascendente o discendente --}}
                            <a
                                href="{{ route('admin.technologies.index') }}?sort=id&order={{ $sort == 'id' && $order != 'DESC' ? 'DESC' : 'ASC' }}">
                                <i
                                    class="fa-solid fa-caret-down ms-2 @if ($order == 'DESC') rotate-180 @endif"></i></a>
                        @endif
                    </th>

                    {{-- TYPE --}}
                    <th scope="col">
                        <a
                            href="{{ route('admin.technologies.index') }}?sort=id&order={{ $sort == 'type_id' && $order != 'DESC' ? 'DESC' : 'ASC' }}">
                            Type</a>

                        @if ($sort == 'type_id')
                            {{-- se si sceglie di gestire a partire dall'id quindi sort=id appare la freccia e cambia rotazione se ascendente o discendente --}}
                            <a
                                href="{{ route('admin.technologies.index') }}?sort=type&order={{ $sort == 'type_id' && $order != 'DESC' ? 'DESC' : 'ASC' }}">
                                <i
                                    class="fa-solid fa-caret-down ms-2 @if ($order == 'DESC') rotate-180 @endif"></i></a>
                        @endif
                    </th>
                    {{-- TEXT --}}
                    <th scope="col"><a
                            href="{{ route('admin.technologies.index') }}?sort=color&order={{ $sort == 'color' && $order != 'DESC' ? 'DESC' : 'ASC' }}">Color</a>

                        @if ($sort == 'color')
                            <a
                                href="{{ route('admin.technologies.index') }}?sort=text&order={{ $sort == 'color' && $order != 'DESC' ? 'DESC' : 'ASC' }}"><i
                                    class="fa-solid fa-caret-down ms-2 @if ($order == 'DESC') rotate-180 @endif"></i></a>
                        @endif
                    </th>
                    {{-- CREATED --}}
                    <th scope="col">
                        <a
                            href="{{ route('admin.technologies.index') }}?sort=created_at&order={{ $sort == 'created_at' && $order != 'DESC' ? 'DESC' : 'ASC' }}">Created</a>

                        @if ($sort == 'created_at')
                            <a
                                href="{{ route('admin.technologies.index') }}?sort=created_at&order={{ $sort == 'created_at' && $order != 'DESC' ? 'DESC' : 'ASC' }}"><i
                                    class="fa-solid fa-caret-down ms-2 @if ($order == 'DESC') rotate-180 @endif"></i></a>
                        @endif
                    </th>
                    {{-- UPDATED --}}
                    <th scope="col">
                        <a
                            href="{{ route('admin.technologies.index') }}?sort=updated_at&order={{ $sort == 'updated_at' && $order != 'DESC' ? 'DESC' : 'ASC' }}">Updated</a>

                        @if ($sort == 'updated_at')
                            <a
                                href="{{ route('admin.technologies.index') }}?sort=updated_at&order={{ $sort == 'updated_at' && $order != 'DESC' ? 'DESC' : 'ASC' }}"><i
                                    class="fa-solid fa-caret-down ms-2 @if ($order == 'DESC') rotate-180 @endif"></i></a>
                        @endif
                    </th>

                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($technologies as $technology)
                    <tr>
                        <th scope="row">{{ $technology->id }}</th>
                        <td>
                            <span class="badge rounded-pill" style="background-color: {{ $technology?->color }}">
                                {{ $technology?->label }}
                            </span>
                            {{-- @dump($project->type) --}}
                        </td>
                        <td>{{ $technology->color }}</td>
                        <td>{{ $technology->created_at }}</td>
                        <td>{{ $technology->updated_at }}</td>


                        <td>
                            <a href="{{ route('admin.technologies.show', $technology) }}"><i
                                    class="fa-solid fa-eye"></i></a>
                            <a href="{{ route('admin.technologies.edit', $technology) }}"><i
                                    class="fa-solid fa-pen ms-3"></i></a>
                            <a type="button" data-bs-toggle="modal" data-bs-target="#delete-modal-{{ $technology->id }}">
                                <i class="fa-solid fa-trash-can ms-3 text-primary"></i>
                            </a>
                        </td>
                    </tr>

                @empty
                @endforelse

            </tbody>
        </table>
        {{-- PAGINATION --}}
        {{ $technologies->links() }}
    </div>

    {{-- MODALE --}}
    @foreach ($technologies as $technology)
        <!-- Modal -->
        <div class="modal fade" id="delete-modal-{{ $technology->id }}" tabindex="-1" data-bs-backdrop="static"
            aria-labelledby="delete-modal-{{ $technology->id }}-label" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="delete-modal-{{ $technology->id }}-label">Conferma eliminazione
                        </h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-start">
                        Sei sicuro di voler eliminare la tecnologia <strong>{{ $technology->label }}</strong> con ID
                        <strong> {{ $technology->id }}</strong>? <br>
                        L'operazione non è reversibile!
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>

                        <form action="{{ route('admin.technologies.destroy', $technology) }}" method="POST"
                            class="">
                            @method('delete')
                            @csrf

                            <button type="submit" class="btn btn-danger">Elimina</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

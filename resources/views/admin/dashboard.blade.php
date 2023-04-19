@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="fs-4 text-secondary my-4">
            {{ __('Dashboard') }}
        </h2>
        <div class="row justify-content-center">
            <div class="col">
                <div class="card">
                    <div class="card-header">{{ __('User Dashboard') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <h3>
                            {{ __('Welcome' . $user->name) }}
                            <span>{{ Auth::user()->name }}</span>
                        </h3>
                    </div>

                    <div class="dashboard-icons d-flex flex-column p-3 mt-3">
                        <div class="col-3">
                            <a class="btn btn-primary d-flex align-items-center"
                                href="{{ route('admin.projects.create') }}"><i
                                    class="fa-solid fa-circle-plus  text-white me-2"></i> <span>
                                    Add a new Project</span></a>
                            {{-- 
                            <i class="fa-solid fa-circle-plus" title="Add Project"></i>
                            <div class="badge-dash ms-4">
                                <h5 class="text-white ms-3 me-4 p-3">Add Project</h5>
                            </div> --}}
                        </div>
                        <div class="col-3">
                            <a class="btn btn-primary d-flex align-items-center"
                                href="{{ route('admin.technologies.index') }}"><i
                                    class="fa-solid fa-lightbulb text-white me-2"></i>Add Tech</a>
                            {{-- <i class="fa-solid fa-lightbulb" title="Add Techs Categories"></i>
                            <div class="badge-dash-tech">
                                <h5 class="text-white ms-3 me-4 p-3">Add Techs Categories</h5>
                            </div> --}}
                        </div>
                        <div class="col-3">
                            <a class="btn btn-primary d-flex align-items-center" href="{{ route('admin.types.index') }}"><i
                                    class="fa-solid fa-diamond text-white me-2"></i>Add Types</a>
                            {{-- <i class="fa-solid fa-diamond" title="Add Techs Categories"></i>
                            <div class="badge-dash-type ps-3 pe-4 d-flex align-items-center">
                                <h5 class="text-white ms-1  p-3">Add Types of Topics</h5>
                            </div> --}}
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

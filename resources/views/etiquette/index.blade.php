@extends('adminlte::page')

@section('content')
    @include('partials.PreviousButton')

    <div class="container-fluid row mb-3 " id="form">
        <div class="col-12 p-4 border-left" id="form-inline1"
             type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
             aria-controls="collapseOne">
            <h4 class=" text-muted">Label {{ request()->routeIs('etiquette.edit') ? __('Update') : __('Create') }}<i
                    class="fas fa-angle-down ml-2"></i>
            </h4>
        </div>
        <form method="post"
              action="{{ request()->routeIs('etiquette.edit') ? route('etiquette.update', $LabelToEdit ?? '') : route('etiquette.store')}}"
              class="row align-items-center justify-content-between w-100 collapse show" enctype="multipart/form-data"
              id="collapseOne" aria-labelledby="form-inline1"
              data-parent="#form">
            @csrf
            @if (request()->routeIs('etiquette.edit'))
                @method('PUT')
            @endif
            <div class="col-12 col-xs-12">
                <div class="form-row">
                    <div class="col-5">
                        <div class="form ">
                            <input class="form-control py-4 @error('name')
                                   is-invalid @enderror" name="name"
                                   id="name"
                                   value="{{ request()->routeIs('etiquette.edit') ? $LabelToEdit -> name : old('name')}}"
                                   required autocomplete="name" autofocus
                                   type="text">
                            <label class="text-black-50 label-name" for="libele">
                                <span class="content-name">{{ __('Name') }}</span>
                            </label>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="form">
                            <input class="form-control py-4 @error('description')
                                   is-invalid @enderror" name="description"
                                   id="description"
                                   value="{{ request()->routeIs('etiquette.edit') ? $LabelToEdit -> description : old('description') }}"
                                   required autocomplete="description" autofocus
                                   type="text">
                            <label class="text-black-50 label-name" for="description">
                                <span class="content-name">{{ __('Description') }}</span>
                            </label>
                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-2 float-right position-relative clearfix">
                        <div class="form-group mt-5">
                            <button type="submit" class="btn btn-success btn-block rounded-pill shadow">
                                {{ request()->routeIs('etiquette.edit') ? __('Update') : __('Create') }}<i
                                    class="fas fa-angle-right ml-2"></i>
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>

    <div class="container-fluid border-top m-1"></div>

    <div class="accordion container-fluid align-items-center justify-content-between w-100 mh-75 p-0"
         id="accordionExample2">
        <div class="container-fluid row align-items-center justify-content-between w-100 mh-75 mt-1">
            <div class="col-sm-12 p-4 border-left " id="TableTable2"
                 type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="true"
                 aria-controls="collapseFour">
                <h4 class=" text-muted">Labels list
                    <i class="fas fa-angle-down ml-2"></i></h4>
            </div>
        </div>
        <div
            class="container-fluid row align-items-center justify-content-between w-100 mh-75 mt-1 collapse"
            id="collapseFour" aria-labelledby="TableTable2"
            data-parent="#accordionExample2">
            <div class="col-sm-12">
                @can('edit-user')
                    @if ($Etiquettes->isEmpty())
                        <p class="h4 text-muted">Vous n'avez pas encore enregistrer d'etiquette</p>
                    @endif
                    @foreach($Etiquettes ?? '' as $etiquette)
                        <div class="card col-sm-3 border-secondary bg-gradient-gray-dark rounded m-1">
                            <div class="card-body container">
                                <p class="card-text h1">{{$etiquette->name}}</p>

                                <form action="{{route('etiquette.destroy',$etiquette)}}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{route('etiquette.edit',$etiquette -> id)}}" class="btn btn-outline-success btn-lg">
                                        <i class="fas fa-pen ml-2"></i>edit</a>
                                    <button class="btn btn-outline-warning btn-lg " type="submit">
                                        <i class="fas fa-minus-circle ml-2"></i>delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                @endcan
            </div>
        </div>
    </div>

@endsection

@extends('adminlte::page')

@section('content')
    @include('partials.PreviousButton')

    <div class="container-fluid row mb-3 " id="form">

        <div class="col-12 p-4 border-left" id="form-inline"
             type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
             aria-controls="collapseTwo">
            <h4 class=" text-muted">Marque {{ request()->routeIs('marque.edit') ? __('Update') : __('Create') }}<i
                    class="fas fa-angle-down ml-2"></i>
            </h4>
        </div>

        <form method="post"
              action="{{ request()->routeIs('marque.edit') ? route('marque.update', $marqueToEdit ?? '') : route('marque.store')}}"
              class="row align-items-center justify-content-between w-100 collapse" enctype="multipart/form-data"
              id="collapseTwo" aria-labelledby="form-inline"
              data-parent="#form">
            @csrf
            @if (request()->routeIs('marque.edit'))
                @method('PUT')
            @endif
            <div class="col-12 col-xs-12">
                <div class="form-row">
                    <div class="col-5">
                        <div class="form ">
                            <input class="form-control py-4 @error('libele')
                                   is-invalid @enderror" name="libele"
                                   id="libele"
                                   value="{{ request()->routeIs('marque.edit') ? $marqueToEdit -> libele : old('libele') }}"
                                   required autocomplete="libele" autofocus
                                   type="text">
                            <label class="text-black-50 label-name" for="libele">
                                <span class="content-name">{{ __('Libele') }}</span>
                            </label>
                            @error('libele')
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
                                   value="{{ request()->routeIs('marque.edit') ? $marqueToEdit -> description : old('description') }}"
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
                                {{ request()->routeIs('marque.edit') ? __('Update') : __('Create') }}<i
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
         id="accordionExample1">
        <div class="container-fluid row align-items-center justify-content-between w-100 mh-75 mt-1">
            <div class="col-sm-12 p-4 border-left " id="TableTable"
                 type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true"
                 aria-controls="collapseThree">
                <h4 class=" text-muted">Marques list
                    <i class="fas fa-angle-down ml-2"></i></h4>
            </div>
        </div>
        <div
            class="container-fluid row align-items-center justify-content-between w-100 mh-75 mt-1 collapse show"
            id="collapseThree" aria-labelledby="TableTable"
            data-parent="#accordionExample1">
            <div class="col-sm-12">
                @can('edit-user')
                    @if ($marques->isEmpty())
                        <div class="container-fluid justify-content-center">
                            <p class="h4 text-muted">Vous n'avez pas encore enregistrer d'etiquette</p>
                        </div>
                    @else
                    <table class="table table-hover table-head-fixed table-responsive-sm overflow-hidden nowrap"
                           id="tableau"
                           data-toggle="tableau"
                    >
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">LIBELE</th>
                            <th scope="col">DESCRIPTION</th>
                            <th scope="col">ACTIONS</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($marques as $marque)

                            <tr>
                                <td>{{$marque->id}}</td>
                                <td>{{$marque->libele}}</td>
                                <td>{{$marque -> description}}</td>
                                <td>
                                    <form action="{{route('marque.destroy',$marque -> id)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <a href="{{route('marque.edit',$marque -> id)}}" class="btn btn-outline-success"><i
                                                class="fas fa-pen ml-2"></i>edit</a>
                                        <button type="submit" class="btn btn-outline-warning"><i
                                                class="fas fa-minus-circle ml-2"></i>delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                    @endif
                @endcan
            </div>
        </div>
    </div>

@endsection

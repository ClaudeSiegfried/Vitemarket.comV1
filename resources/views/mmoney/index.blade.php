@extends('adminlte::page')

@section('content')
    @include('partials.PreviousButton')

    <div class="container-fluid row mb-3 " id="form">
        <div class="col-12 p-4 border-left" id="form-inline"
             type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
             aria-controls="collapseTwo">
            <h4 class=" text-muted">Money System
                Provider {{ request()->routeIs('mmoney.edit') ? __('Update') : __('Create') }}<i
                    class="fas fa-angle-down ml-2"></i>
            </h4>
            <form method="post"
                  action="{{ request()->routeIs('mmoney.edit') ? route('mmoney.update',$mmoneyToEdit) : route('mmoney.store')}}"
                  class="row align-items-center justify-content-between w-100 collapse show" enctype="multipart/form-data"
                  id="collapseTwo" aria-labelledby="form-inline"
                  data-parent="#form">
                @csrf
                @if (request()->routeIs('mmoney.edit'))
                    @method('PUT')
                @endif
                <div class="col-12 col-xs-12">
                    <div class="form-row">
                        <div class="col-5">
                            <div class="form ">
                                <input class="form-control py-4 @error('fam')
                                   is-invalid @enderror" name="fam"
                                       id="fam"
                                       value="{{ request()->routeIs('mmoney.edit') ? $mmoneyToEdit -> fam : old('fam') }}"
                                       required autocomplete="fam" autofocus
                                       type="text">
                                <label class="text-black-50 label-name" for="fam">
                                    <span class="content-name">{{ __('Provider Name') }}</span>
                                </label>
                                @error('fam')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="form">
                                <input class="form-control py-4 @error('credential')
                                   is-invalid @enderror" name="credential"
                                       id="credential"
                                       value="{{ request()->routeIs('mmoney.edit') ? $mmoneyToEdit -> credential : old('credential') }}"
                                       required autocomplete="credential" autofocus
                                       type="password">
                                <label class="text-black-50 label-name" for="credential">
                                    <span class="content-name">{{ __('Short description') }}</span>
                                </label>
                                @error('credential')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-2 float-right position-relative clearfix">
                            <div class="form-group mt-5">
                                <button type="submit" class="btn btn-success btn-block rounded-pill shadow">
                                    {{ request()->routeIs('mmoney.edit') ? __('Update') : __('Create') }}<i
                                        class="fas fa-angle-right ml-2"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <div class="accordion container-fluid align-items-center justify-content-between w-100 mh-75 p-0"
         id="accordionExample">
        <div class="container-fluid row align-items-center justify-content-between w-100 mh-75 mt-1">
            <div class="col-sm-12 p-4 border-left " id="TableTable"
                 type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
                 aria-controls="collapseOne">
                <h4 class=" text-muted">Providers list
                    <i class="fas fa-angle-down ml-2"></i></h4>
            </div>
        </div>
        <div
            class="container-fluid row align-items-center justify-content-between w-100 mh-75 mt-1 collapse show"
            id="collapseOne" aria-labelledby="TableTable"
            data-parent="#accordionExample">
            <div class="col-sm-12">
                @can('edit-user')
                    <table class="table table-hover table-head-fixed table-responsive-sm overflow-hidden nowrap"
                           id="tableau"
                           data-toggle="tableau"
                    >
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">PAYMENT SYSTEM PROVIDER</th>
                            <th scope="col">CREDENTIAL</th>
                            <th scope="col">ACTIONS</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($mmoneys as $mmoney)

                            <tr>
                                <td>{{$mmoney->id}}</td>
                                <td>{{$mmoney->fam}}</td>
                                <td>{{$mmoney -> credential}}</td>
                                <td>
                                    @can('manage-users')
                                        <form action="{{route('mmoney.destroy',$mmoney -> id)}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <a href="{{route('mmoney.edit',$mmoney -> id)}}" class="btn btn-outline-success"><i
                                                    class="fas fa-pen ml-2"></i>edit</a>
                                            <button type="submit" class="btn btn-outline-warning"><i
                                                    class="fas fa-minus-circle ml-2"></i>delete
                                            </button>
                                        </form>
                                    @endCan
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                @endcan
            </div>
        </div>
    </div>

    <div class="container-fluid p-4 border-left mt-5">
        <h4 class="text-muted">
            Money System
            Provider <i class="fas fa-angle-down ml-2"></i>
        </h4>
    </div>

    <div class="row container-fluid px-3 py-3" style="height: 10vh !important;">
        @foreach($mmoneys as $mmoney)
            <div
                class="col-md-2 elevation-2 text-white rounded-pill bg-gradient-green text-sm-center text-center align-self-center">
                {{$mmoney->fam}}
            </div>
        @endforeach
    </div>

@endsection

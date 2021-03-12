@extends('adminlte::page')

@section('content')
    @include('partials.PreviousButton')
    <div class="container-fluid row mb-3 ">
        <div class="col-12 p-4 border-left">
            <h4 class=" text-muted">Discounts {{ request()->routeIs('discounts.edit') ? __('Update') : __('Create') }}<i
                    class="fas fa-angle-right ml-2"></i></h4>
            <form method="post"
                  action="{{ request()->routeIs('discounts.edit') ? route('discounts.update', $discountToEdit) : route('discounts.store')}}"
                  class="row align-items-center justify-content-between w-100" enctype="multipart/form-data">
                @csrf
                @if (request()->routeIs('discounts.edit'))
                    @method('PUT')
                @endif
                <div class="col-12 col-xs-12">
                    <div class="form-row">
                        <div class="col-5">
                            <div class="form ">
                                <input class="form-control py-4 @error('name')
                                   is-invalid @enderror" name="name"
                                       id="name"
                                       value="{{ request()->routeIs('discounts.edit') ? $discountToEdit -> name : old('name') }}"
                                       required autocomplete="name" autofocus
                                       type="text">
                                <label class="text-black-50 label-name" for="name">
                                    <span class="content-name">{{ __('name') }}</span>
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
                                <input class="form-control py-4 @error('value')
                                   is-invalid @enderror" name="value"
                                       id="value"
                                       value="{{ request()->routeIs('discounts.edit') ? $discountToEdit -> value : old('value') }}"
                                       required autocomplete="value" autofocus
                                       type="number">
                                <label class="text-black-50 label-name" for="value">
                                    <span class="content-name">{{ __('value') }}</span>
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
                                    {{ request()->routeIs('discounts.edit') ? __('Update') : __('Create') }}<i
                                        class="fas fa-angle-right ml-2"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
    <div class="container-fluid row py-3">
        <h4 class="ml-4 text-muted ">Discounts list<i
                class="fas fa-angle-right ml-2"></i></h4>
        <div class="row container-fluid ">
            @foreach($discounts as $d)
                <div class="card col-sm-3 border-secondary bg-gradient-gray-dark rounded m-1">
                    <div class="card-body container">
                        <h5 class="card-title text-muted h3">{{$d->name}}</h5>
                        <p class="card-text h1">{{$d->value}} %</p>

                        <form action="{{route('discounts.destroy',$d)}}" method="post">
                            @csrf
                            @method('DELETE')
                            <a href="{{route('discounts.edit',$d -> id)}}" class="btn btn-outline-success btn-lg">
                                <i class="fas fa-pen ml-2"></i>edit</a>
                            <button class="btn btn-outline-warning btn-lg " type="submit">
                                <i class="fas fa-minus-circle ml-2"></i>delete
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection


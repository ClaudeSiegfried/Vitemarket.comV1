@extends('adminlte::page')

@section('content')
    @include('partials.PreviousButton')
    <div class="container-fluid row ">
        <div class="col-12 p-4 border-left">
            <h4 class=" text-muted">Percentage {{ request()->routeIs('discounts.edit') ? __('Update') : __('Create') }}
                <i
                    class="fas fa-angle-down ml-2"></i></h4>
        </div>
        <form method="post"
              action="{{route('percentage.store')}}"
              class="row container-fluid align-items-center justify-content-center w-100 border-right">
            @csrf
            @if (request()->routeIs('discounts.edit'))
                @method('PUT')
            @endif

            <div class="col-5">

                <select class="selectpicker form-control
                        @error('mmoney_id') is-invalid @enderror
                        container"
                        data-live-search="true" name="mmoney_id"
                        required id="mmoney_id"
                        title="Select a provider">
                    @foreach($mmoneys ?? '' as $item)
                        <option value="{{$item -> id}}"
                                @if (($percentageToEdit ?? '')&& $percentageToEdit->id === $item -> id)
                                selected
                            @endif
                        >
                            {{$item -> fam}}
                        </option>
                    @endforeach
                </select>
                @error('mmoney_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

            </div>
            <div class="col-5">
                <div class="form">
                    <input class="form-control py-3 @error('value')
                                   is-invalid @enderror"
                           name="percentage" min="1"
                           id="percentage" max="10"
                           value="{{(request()->routeIs('percentage.edit') ? $percentageToEdit->provider_percentage : old('percentage'))}}"
                           required autocomplete="value" autofocus
                           type="number">
                    <label class="text-black-50 label-name" for="percentage">
                        <span class="content-name">{{ __('value') }}</span>
                    </label>
                    @error('percentage')
                    <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                                </span>
                    @enderror
                </div>
            </div>
            <div class="col-2">
                <div class="form-group mt-5">
                    <button type="submit" class="btn btn-success btn-block rounded-pill shadow">
                        {{ request()->routeIs('percentage.edit') ? __('Update') : __('Create') }}<i
                            class="fas fa-angle-right ml-2"></i>
                    </button>
                </div>
            </div>

        </form>
    </div>
    <div class="container-fluid row py-3">
        <div class="col-12 p-4 border-left">
            <h4 class="text-muted ">Provider required percentage list<i
                    class="fas fa-angle-down ml-2"></i></h4>
        </div>
        <div class="row container-fluid mt-3 px-4 align-content-center border-right">
            @foreach($mmoneys as $percentage)
                <div class="card col-sm-3 border-secondary bg-gradient-gray-dark rounded m-1">
                    <div class="card-body container row">
                        <div class="col">
                            <h5 class="card-title text-muted h3">{{$percentage->fam}}</h5>
                            <p class="card-text h1">{{$percentage->provider_percentage}} %</p>
                        </div>

                        <div class="col justify-content-center align-self-center">
                            <form action="{{route('percentage.edit',$percentage->id)}}" method="GET">
                                @csrf
                                @method('GET')
                                <button class="btn btn-outline-success btn-lg container" type="submit">
                                    <i class="fas fa-pen ml-2"></i>edit
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection


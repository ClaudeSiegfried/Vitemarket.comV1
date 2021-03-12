@extends('adminlte::page')

@section('content')
    @include('partials.PreviousButton')
    <div class="container-fluid row mb-3 " id="form1">
        <div class="col-12 p-4 border-left">
            <div id="form-inline1" class="btn btn-lg btn-tool"
                 type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
                 aria-controls="collapseOne">
                <h4 class=" text-muted">Per Kilometer Delivery Fees<i
                        class="fas fa-angle-down ml-2"></i>
                </h4>
            </div>
            <form method="post"
                  action="{{ request()->routeIs('deliveryFees.edit') ? route('deliveryFees.edit',$deliveryToEdit) : route('deliveryFees.store')}}"
                  class="row align-items-center justify-content-between w-100 collapse show" enctype="multipart/form-data"
                  id="collapseOne" aria-labelledby="form-inline1"
                  data-parent="#form1">
                @csrf
                @if (request()->routeIs('deliveryFees.edit'))
                    @method('PUT')
                @endif
                <div class="col-12 col-xs-12">
                    <div class="form-row">
                        <div class="col-5 d-none">
                            <div class="form ">
                                <input class="form-control py-4 @error('couverture')
                                   is-invalid @enderror" name="couverture"
                                       id="couverture"
                                       value="1 km "
                                       required autocomplete="couverture" autofocus
                                       type="text" readonly="readonly">
                                <label class="text-black-50 label-name" for="fam">
                                    <span class="content-name">{{ __('name') }}</span>
                                </label>
                                @error('couverture')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-5">
                            <div class="form">
                                <input class="form-control py-4 @error('frais')
                                   is-invalid @enderror" name="frais"
                                       id="frais"
                                       value="{{ $Km ?? old('frais') }}"
                                       required autocomplete="frais" autofocus
                                       type="number">
                                <label class="text-black-50 label-name" for="frais">
                                    <span class="content-name">{{ __('Fees') }}</span>
                                </label>
                                @error('frais')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-2 float-right position-relative clearfix">
                            <div class="form-group mt-5">
                                <button type="submit" class="btn btn-success btn-block rounded-pill shadow">
                                    {{ request()->routeIs('deliveryFees.edit') ? __('Update') : __('SetUp') }}<i
                                        class="fas fa-angle-right ml-2"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="container-fluid row mb-3 " id="form">
        <div class="col-12 p-4 border-left">
            <div id="form-inline" class="btn btn-lg btn-tool"
                 type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
                 aria-controls="collapseTwo">
                <h4 class=" text-muted">Global Delivery Fees<i
                        class="fas fa-angle-down ml-2"></i>
                </h4>
            </div>
            <form method="post"
                  action="{{ request()->routeIs('deliveryFees.edit') ? route('deliveryFees.edit',$deliveryToEdit) : route('deliveryFees.store')}}"
                  class="row align-items-center justify-content-between w-100 collapse show" enctype="multipart/form-data"
                  id="collapseTwo" aria-labelledby="form-inline"
                  data-parent="#form">
                @csrf
                @if (request()->routeIs('deliveryFees.edit'))
                    @method('PUT')
                @endif
                <div class="col-12 col-xs-12">
                    <div class="form-row">
                        <div class="col-5 d-none">
                            <div class="form ">
                                <input class="form-control py-4 @error('couverture')
                                   is-invalid @enderror" name="couverture"
                                       id="couverture"
                                       value="Global"
                                       required autocomplete="couverture" autofocus
                                       type="text" readonly="readonly">
                                <label class="text-black-50 label-name" for="fam">
                                    <span class="content-name">{{ __('name') }}</span>
                                </label>
                                @error('couverture')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-5 ">
                            <div class="form">
                                <input class="form-control py-4 @error('frais')
                                   is-invalid @enderror" name="frais"
                                       id="frais"
                                       value="{{ $Global ?? old('frais') }}"
                                       required autocomplete="frais" autofocus
                                       type="number">
                                <label class="text-black-50 label-name" for="frais">
                                    <span class="content-name">{{ __('Fees') }}</span>
                                </label>
                                @error('frais')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-2 float-right position-relative clearfix">
                            <div class="form-group mt-5">
                                <button type="submit" class="btn btn-success btn-block rounded-pill shadow">
                                    {{ request()->routeIs('deliveryFees.edit') ? __('Update') : __('SetUp') }}<i
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
        <h4 class="ml-4 text-muted ">Extra Fees list<i
                class="fas fa-angle-right ml-2"></i></h4>
        <div class="row container-fluid ">
            @foreach($Tarifs ?? '' as $tarif)
                <div class="card col-sm-3 border-secondary bg-gradient-gray-dark rounded m-1">
                    <div class="card-body container row">
                        <div class="col-9">
                            <h5 class="card-title text-muted h3">{{$tarif->couverture}}</h5>
                            <p class="card-text h1">{{$tarif->frais}} </p>
                        </div>
                        <div class="col-3">
                            <p class="card-text h1">F.CFA</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection



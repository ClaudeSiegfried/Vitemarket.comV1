@extends('adminlte::page')

@section('content')
    @include('partials.PreviousButton')
    <div class="container-fluid row w-100 h-100">
        <form method="post" action="{{ route('applyDiscount.savediscountsuser')}}"
              class="row align-items-center justify-content-between w-100 mh-75 p-5 border-right">
            @csrf
            @method('POST')
            <div class="col-sm-12 p-4 border-left">
                <h4 class=" text-muted">Apply discount to a customer
                    <i class="fas fa-angle-down ml-2"></i></h4>
            </div>
            <div class="col-sm-12 container-fluid">
                <div class="form-row mt-5">

                    <div class="col-md-5">
                        <select class="selectpicker form-control
                            @error('User_id') is-invalid @enderror"
                                data-live-search="true" name="User_id"
                                required id="User_id"
                                title="Select a user">
                            @foreach($Users as $User)
                                <option value="{{$User -> id}}"
                                        @if (($UserToEdit ?? '')&& $UserToEdit->id === $User -> id)
                                        selected
                                    @endif
                                >
                                    {{$User -> name}}
                                </option>
                            @endforeach
                        </select>
                        @error('User_id')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>

                    <div class="col-md-5">
                        <select class="selectpicker form-control
                            @error('Discount_id') is-invalid @enderror"
                                data-live-search="true" name="Discount_id"
                                required id="Discount_id"
                                title="Discount to apply">
                            @foreach($Discounts ?? '' as $Discount)
                                <option value="{{$Discount -> id}}"
                                        @if (($DiscountToEdit ?? '')&& $DiscountToEdit->id === $Discount -> id)
                                        selected
                                    @endif
                                >
                                    {{$Discount -> name}} : {{$Discount -> value}}
                                </option>
                            @endforeach
                        </select>
                        @error('Discount_id')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>

                    <div class="col-md-2 ">
                        <button type="submit" class="btn btn-success btn-block rounded-pill shadow">
                            {{ __('Apply') }}<i class="fas fa-angle-right ml-2"></i>
                        </button>
                    </div>

                </div>
            </div>
        </form>

        <div class="accordion container-fluid align-items-center justify-content-between w-100 mh-75 p-0"
             id="accordionExample">
            <div class="container-fluid row align-items-center justify-content-between w-100 mh-75 p-5 mt-1">
                <div class="col-sm-12 p-4 border-left " id="TableTable"
                     type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true"
                     aria-controls="collapseOne">
                    <h4 class=" text-muted">Discounts to users list
                        <i class="fas fa-angle-down ml-2"></i></h4>
                </div>
            </div>
            <div
                class="container-fluid row align-items-center justify-content-between w-100 mh-75 p-5 mt-1 collapse show"
                id="collapseOne" aria-labelledby="TableTable"
                data-parent="#accordionExample">
                <div class="col-sm-12 p-4">
                    <table class="table table-hover table-head-fixed table-responsive-sm overflow-hidden nowrap"
                           id="tableau"
                           data-toggle="tableau"
                    >
                        <thead>
                        <tr>
                            <th scope="col">DISCOUNT</th>
                            <th scope="col">PERCENTAGE</th>
                            <th scope="col">CUSTOMER</th>
                            <th scope="col">ACTIONS</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($UsersWithDiscounts ?? '' as $User)
                            <tr>
                                <td>{{$User->discount()->get()->first()->name ?? ''}}</td>
                                <td><span class="badge badge-dark">{{$User->discount()->get()->first()->value ?? ''}}
                                        %</span></td>
                                <td>{{$User->name}}</td>
                                <td>
                                    <form action="{{route('applyDiscount.deletediscountsuser',$User->id)}}"
                                          method="post">
                                        @csrf
                                        @method('DELETE')
                                        <a href="{{route('applyDiscount.editdiscountsuser',$User->id)}}"
                                           class="btn btn-outline-success">
                                            <i class="fas fa-pen ml-2"></i>edit</a>
                                        <button class="btn btn-outline-warning" type="submit">
                                            <i class="fas fa-minus-circle ml-2"></i>End discount
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection

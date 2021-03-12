@extends('adminlte::page')

@section('content')

    <form method="post" action="{{route('marque.store')}}"
          class="row align-items-center justify-content-between w-100 h-75" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="col-md-6 col-xs-12">

            <div class="form-row">
                <div class="col-md-6">
                    <div class="form ">
                        <input class="form-control py-4 @error('name')
                                   is-invalid @enderror" name="name"
                               id="name" value="{{ old('name')}}"
                               required autocomplete="name" autofocus
                               type="text">
                        <label class="text-black-50 label-name" for="name">
                            <span class="content-name">{{ __('Name') }}</span>
                        </label>
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form">
                        <input class="form-control py-4 @error('tel')
                                   is-invalid @enderror" name="tel"
                               id="tel" value="{{old('tel') }}"
                               required autocomplete="tel" autofocus
                               type="tel">
                        <label class="text-black-50 label-name" for="tel">
                            <span class="content-name">{{ __('Phone Number') }}</span>
                        </label>
                        @error('tel')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mt-5 mb-0">
                        <button type="submit" class="btn btn-success btn-block rounded-pill shadow">
                            {{ __('Update') }}<i class="fas fa-angle-right ml-2"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </form>

@endsection

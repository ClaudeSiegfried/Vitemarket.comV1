@extends('adminlte::page')

@section('content')
    @include('partials.PreviousButton')

    <form method="post" action="{{ route('categorie.update', $categorie)}}"
          class="row align-items-center justify-content-between w-100 h-75" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="col-md-6 col-xs-12 p-5 h-75">

            <div class="form-row">
                <div class="col-md-12">
                    <div class="form ">
                        <input class="form-control py-4 @error('libele')
                                   is-invalid @enderror" name="libele"
                               id="libele" value="{{ $categorie -> libele}}"
                               required autocomplete="libele" autofocus
                               type="text">
                        <label class="text-black-50 label-name" for="libele">
                            <span class="content-name">{{ __('Nom') }}</span>
                        </label>
                        @error('libele')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12">

                    <label class="text-black-50 label-name" for="description">
                    </label>
                    <textarea class="form-control py-4 @error('description')
                                    is-invalid @enderror"
                              id="description"
                              name="description"
                              required
                    >{{ $categorie -> description }}</textarea>
                    @error('description')
                    <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                    @enderror

                </div>

            </div>

            <div class="form-group mt-5 mb-0">
                <button type="submit" class="btn btn-success btn-block rounded-pill shadow">
                    {{ __('Update category') }}<i class="fas fa-angle-right ml-2"></i>
                </button>
            </div>

        </div>

        <div class="col-md-6 col-xs-12 upload-btn position-relative align-self-center">
            <label class="text-black-50 text-nowrap" for="photo_id">
                <span class="content-name">{{ __('Add an image') }}</span>
            </label>
            <input type="file" accept="image" dropzone="move" class="" id="photo_id" name="photo_id">
        </div>
    </form>

@stop

@section('js')
    <script>
        $('#photo_id').change(function (event) {
            var TempImg = URL.createObjectURL(event.target.files[0]);
            localStorage.setItem('TempImg', URL.createObjectURL(event.target.files[0]));
            $(".upload-btn").fadeIn("fast").css('background-image', "url(" + TempImg + ")");
            $("label[for='photo_id']").hide();
            console.log(URL.createObjectURL(event.target.files[0]));
        });


    </script>
@stop

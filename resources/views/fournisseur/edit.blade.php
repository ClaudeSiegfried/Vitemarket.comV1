@extends('adminlte::page')

@section('content')
    @include('partials.PreviousButton')

    <div class="container-fluid row mb-3 ">
        <form method="post" action="{{ route('fournisseur.update', $fournisseur)}}"
              class="row align-items-center justify-content-between w-100 h-75 "
              enctype="multipart/form-data" id="Form_1">
            @csrf
            @method('PUT')
            <div class="col-12 p-4 border-left">
                <h4 class=" text-muted">Supplier {{ __('Edit') }}<i
                        class="fas fa-angle-down ml-3"></i></h4>
            </div>

            <div class="col-12 p-4 border-right">
                <div class="row">
                    <div class="form col-md-3 col-xs-12">
                        <input class="form-control py-4 @error('etablissement')
                                       is-invalid @enderror" name="etablissement"
                               id="etablissement" value="{{ $fournisseur -> etablissement }}"
                               required autocomplete="etablissement" autofocus
                               type="text">
                        <label class="text-black-50 label-name" for="etablissement">
                            <span class="content-name">{{ __('Etablissement') }}</span>
                        </label>
                        @error('etablissement')
                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>
                    <div class="form col-md-3 col-xs-12">
                        <input class="form-control py-4 @error('rccm')
                                       is-invalid @enderror" name="rccm"
                               id="rccm" value="{{ $fournisseur -> rccm }}"
                               required autocomplete="rccm" autofocus
                               type="text">
                        <label class="text-black-50 label-name" for="rccm">
                            <span class="content-name">{{ __('Rccm') }}</span>
                        </label>
                        @error('rccm')
                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>
                    <div class="form col-md-3 col-xs-12">
                        <input class="form-control py-4 @error('nif')
                                       is-invalid @enderror" name="nif"
                               id="nif" value="{{ $fournisseur -> nif }}"
                               required autocomplete="nif" autofocus
                               type="text">
                        <label class="text-black-50 label-name" for="name">
                            <span class="content-name">{{ __('Numero d\'identification Fiscale') }}</span>
                        </label>
                        @error('nif')
                        <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                        @enderror
                    </div>
                    <div class="form col-md-3 col-xs-12">
                        <input class="form-control py-4 @error('description')
                                       is-invalid @enderror" name="description"
                               id="description" value="{{ $fournisseur -> description }}"
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
            </div>

            <div class="col-md-6 col-xs-12">

                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form ">
                            <input class="form-control py-4 @error('name')
                                   is-invalid @enderror" name="name"
                                   id="name" value="{{ $user -> name }}"
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
                                   id="tel" value="{{ $user -> tel }}"
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
                </div>

                <div class="form-group">
                    <div class="form">
                        <input class="form-control @error('email')
                               is-invalid @enderror" name="email" id="email"
                               value="{{ $user -> email }}" required
                               autocomplete="email" autofocus
                               type="email/text">
                        <label class="text-black-50 label-name" for="email">
                            <span class="content-name">{{ __('E-Mail Address') }}</span>
                        </label>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form ">
                            <input class="form-control py-4 @error('metier')
                                    is-invalid @enderror" name="metier"
                                   id="metier" value="{{ $user -> metier }}"
                                   required autocomplete="metier" autofocus
                                   type="text">
                            <label class="text-black-50 label-name" for="metier">
                                <span class="content-name">{{ __('Metier') }}</span>
                            </label>
                            @error('metier')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form">
                            <input class="form-control py-4 @error('tel')
                                   is-invalid @enderror" name="date_de_naissance"
                                   id="date_de_naissance"
                                   value="{{ $user -> date_de_naissance }}"
                                   required autocomplete="date_de_naissance"
                                   autofocus type="date"
                            >
                            <label class="text-black-50 label-name" for="date_de_naissance">
                                <span class="content-name">{{ __('Birthday') }}</span>
                            </label>
                            @error('date_de_naissance')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group mt-5 mb-0">
                    <button type="button" class="btn btn-success btn-flat rounded-pill shadow" onclick="submitForm()">
                        {{ __('Update') }}<i class="fas fa-angle-right ml-2"></i>
                    </button>
                </div>

            </div>

            <div class="col-md-6 col-xs-12 ">

                <div class="form-group mt-3 pt-4">
                    <select class="selectpicker form-control
                            @error('role') is-invalid @enderror"
                            data-live-search="true" name="role[]"
                            required multiple id="role"
                            title="Define user's role">
                        @foreach($roles as $role)
                            <option value="{{$role -> id}}"
                                    @if ($user->roles()->pluck('id')->contains($role->id))
                                    data-subtext="(current)"
                                    multiple="true"
                                    selected
                                @endif
                            >
                                {{$role -> name}}
                            </option>
                        @endforeach
                    </select>
                    @error('role')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="upload-btn position-relative align-self-center">
                    <label class="text-black-50 text-nowrap" for="photo_id">
                        <span class="content-name">{{ __('Add an image') }}</span>
                    </label>
                    <input type="file" accept="image" dropzone="move" class="" id="photo_id" name="photo_id">
                </div>

            </div>

        </form>
    </div>



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

        function submitForm() {
            document.getElementById("Form_1").submit();
            document.getElementById("Form_2").submit();

        }


    </script>
@stop

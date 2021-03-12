@extends('adminlte::page')

@section('content')
    @include('partials.PreviousButton')
    <div class="container-fluid">
        <form method="post" action="{{ route('produit.update', $produit)}}"
              class="row align-items-center justify-content-between w-100 h-75"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="col-md-6 col-xs-12 py-auto">

                <div class="form-group">
                    <div class="form">
                        <input class="form-control @error('Libele')
                               is-invalid @enderror" name="Libele" id="Libele"
                               value="{{$produit->Libele}}" required
                               autocomplete="Libele" autofocus
                               type="text">
                        <label class="text-black-50 label-name" for="Libele">
                            <span class="content-name">{{ __('Product name') }}</span>
                        </label>
                        @error('Libele')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form ">
                            <input class="form-control py-4 @error('taille')
                                   is-invalid @enderror" name="taille"
                                   id="taille" value="{{ $produit->taille}}"
                                   required autocomplete="taille" autofocus min="0"
                                   type="number" data-suffix="CM" data-decimals="2">
                            <label class="text-black-50 label-name" for="taille">
                                <span class="content-name">{{ __('Taille (en Cm)') }}</span>
                            </label>
                            @error('taile')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form">
                            <input class="form-control py-4 @error('poids')
                                   is-invalid @enderror" name="poids"
                                   id="poids" value="{{ $produit->poids}}"
                                   required autocomplete="poids" autofocus
                                   type="number" data-suffix="KG" min="0">
                            <label class="text-black-50 label-name" for="poids">
                                <span class="content-name">{{ __('Poids (en Kg)') }}</span>
                            </label>
                            @error('poids')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form ">
                            <input class="form-control py-4 @error('quantite_physique')
                                   is-invalid @enderror" name="quantite_physique"
                                   id="quantite_physique" value="{{ $stock->quantite_physique }}"
                                   required autocomplete="quantite_physique" autofocus min="0"
                                   type="number">
                            <label class="text-black-50 label-name" for="quantite_physique">
                                <span class="content-name">{{ __('Quantite Physique') }}</span>
                            </label>
                            @error('quantite_physique')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form">
                            <input class="form-control py-4 @error('expiration_id')
                                   is-invalid @enderror" name="expiration_id"
                                   id="expiration_id" value="{{ $exp->date_de_peremption}}"
                                   required autocomplete="expiration_id" autofocus
                                   type="date">
                            <label class="text-black-50 label-name" for="expiration_id">
                                <span class="content-name">{{ __('Date d\'expiration') }}</span>
                            </label>
                            @error('expiration_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form ">
                            <input class="form-control py-4 @error('prix')
                                    is-invalid @enderror" name="prix"
                                   id="prix" value="{{ $produit->prix }}"
                                   required autocomplete="prix" autofocus min="0"
                                   type="number" data-suffix="F.CFA" data-decimals="2">
                            <label class="text-black-50 label-name" for="prix">
                                <span class="content-name">{{ __('Prix (en F.CFA)') }}</span>
                            </label>
                            @error('prix')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form">
                            <input class="form-control py-4 @error('date_de_creation')
                                   is-invalid @enderror" name="date_de_creation"
                                   id="date_de_creation"
                                   value="{{ $produit->date_de_creation}}"
                                   required autocomplete="date_de_creation"
                                   autofocus type="date"
                            >
                            <label class="text-black-50 label-name" for="date_de_creation">
                                <span class="content-name">{{ __('Factory date') }}</span>
                            </label>
                            @error('date_de_creation')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-row mt-5">
                    <div class="col-12">
                        <select class="selectpicker form-control
                            @error('fournisseur_id') is-invalid @enderror"
                                data-live-search="true" name="fournisseur_id"
                                required id="fournisseur_id"
                                title="Select supplier">
                            @foreach($fournisseurs as $fournisseur)
                                <option value="{{$fournisseur -> id}}"
                                        @if ($produit->fournisseur_id === $fournisseur->id)
                                        data-subtext="(current)"
                                        selected
                                    @endif
                                >
                                    {{$fournisseur -> etablissement}}
                                </option>
                            @endforeach
                        </select>
                        @error('fournisseur_id')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>
                </div>

                <div class="form-row mt-5">

                    <div class="col-md-6 ">
                        <select class="selectpicker form-control
                            @error('categorie_id') is-invalid @enderror"
                                data-live-search="true" name="categorie_id"
                                required id="categorie_id"
                                title="Select product category">
                            @foreach($categories as $categorie)
                                <option value="{{$categorie -> id}}"
                                        @if ($produit->categorie_id === $categorie->id)
                                        data-subtext="(current)"
                                        selected
                                    @endif
                                >
                                    {{$categorie -> libele}}
                                </option>
                            @endforeach
                        </select>
                        @error('categorie_id')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <select class="selectpicker form-control
                            @error('marque_id') is-invalid @enderror"
                                data-live-search="true" name="marque_id"
                                required id="marque_id"
                                title="Select mark">
                            @foreach($marques as $marque)
                                <option value="{{$marque -> id}}"
                                        @if ($produit->marque_id === $marque->id)
                                        data-subtext="(current)"
                                        selected
                                    @endif
                                >
                                    {{$marque -> libele}}
                                </option>
                            @endforeach
                        </select>
                        @error('marque_id')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>

                </div>

                <div class="form-row mt-5">
                    <div class="col-12">
                        <select class="selectpicker form-control
                            @error('etiquette') is-invalid @enderror"
                                data-live-search="true" name="etiquette[]"
                                multiple id="etiquette"
                                title="Select labels">
                            @foreach($etiquettes as $etiquette)
                                <option value="{{$etiquette -> id}}"
                                        @if ($produit->label->pluck('id')->contains($etiquette->id))
                                        data-subtext="(current)"
                                        selected
                                    @endif
                                >
                                    {{$etiquette -> name}}
                                </option>
                            @endforeach
                        </select>
                        @error('etiquette')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

            </div>

            <div class="col-md-6 col-xs-12 align-self-center py-3">

                <div class="form-row mt-5">

                    <div class="col-md-12">
                        <div class="form">
                            <input class="form-control @error('code_gen')
                               is-invalid @enderror" name="code_gen" id="code_gen"
                                   value="{{$produit->code_gen}}" required
                                   autocomplete="code_gen" autofocus
                                   type="text">
                            <label class="text-black-50 label-name" for="code_gen">
                                <span class="content-name">{{ __('Generic code') }}</span>
                            </label>
                            @error('code_gen')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-12">

                        <label class="text-black-50 label-name" for="description">Description
                        </label>
                        <textarea class="form-control py-4 @error('description')
                                    is-invalid @enderror"
                                  id="description"
                                  name="description" content="{{ old('description') }}"
                                  required
                        >{{$produit->description}}</textarea>
                        @error('description')
                        <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror

                    </div>

                </div>

                <div class="container upload-btn mt-4">
                    <label class="text-black-50 text-nowrap" for="photo_id">
                        <span class="content-name">{{ __('Add an image') }}</span>
                    </label>
                    <input type="file" accept="image" dropzone="move" class="" id="photo_id" name="photo_id">
                </div>

            </div>

            <div class="form-group mt-4 mb-0 pl-3">
                <button type="submit" class="btn btn-success btn-block rounded-pill shadow">
                    {{ __('Update product') }}<i class="fas fa-angle-right ml-2"></i>
                </button>
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

    </script>
@stop

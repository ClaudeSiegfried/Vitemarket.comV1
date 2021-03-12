@extends('adminlte::page')

@section('content')
    @include('partials.PreviousButton')


    <div class="accordion container-fluid align-items-center justify-content-between w-100 mh-75 p-0"
         id="accordionExample1">
        <div class="container-fluid row align-items-center justify-content-between w-100 mh-75 mt-1">
            <div class="col-sm-12 p-4 border-left " id="TableTable"
                 type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true"
                 aria-controls="collapseThree">
                <h4 class=" text-muted">Products list
                    <i class="fas fa-angle-down ml-2"></i></h4>
            </div>
        </div>
        <div
            class="container-fluid row align-items-center justify-content-between w-100 mh-75 mt-1 collapse show"
            id="collapseThree" aria-labelledby="TableTable"
            data-parent="#accordionExample1">
            <div class="col-sm-12">
                @can('edit-user')
                    <div class="container-fluid row">
                        <div class="col-12">
                            <a href="{{route('produit.create')}}" class="btn btn-success rounded-pill float-right mb-4"> <i
                                    class="fas fa-plus mr-2"></i>Add a product</a>
                        </div>
                    </div>

                    @if ($produits->isEmpty())
                        <div class="container-fluid justify-content-center">
                            <p class="h4 text-muted">Vous n'avez pas encore enregistrer de produits</p>
                        </div>
                    @else
                        <table class="table table-hover table-head-fixed table-responsive-sm overflow-hidden nowrap"
                               id="tableau"
                               data-toggle="tableau"
                        >
                            <thead>
                            <tr>
                                <th scope="col">PHOTO</th>
                                <th scope="col">LIBELE</th>
                                <th scope="col">CATEGORIE</th>
                                <th scope="col">MARQUE</th>
                                <th scope="col">PRIX</th>
                                <th scope="col">ACTIONS</th>
                                <th scope="col">FOURNISSEUR</th>
                                <th scope="col">DESCRIPTION</th>

                            </tr>
                            </thead>

                            <tbody>
                            @foreach($produits as $produit)

                                <tr>
                                    <td>
                                        <img class="img-thumbnail rounded-circle object-fit"
                                             @if (!empty($path = (implode($produit->photo()->get()->pluck('path')->toArray()))))
                                             {{$route = route('photo.display', $path)}}
                                             @else
                                             {{$route = asset('custom/assets/ViteMarket/1.5x/ViteMarket - Asset 1hdpi.png')}}
                                             {{--{{dd($path)}}--}}
                                             @endif
                                             src="{{$route}}"
                                             alt="">
                                    </td>
                                    <td>{{$produit->Libele}}</td>
                                    <td>{{Warehouse::getModelAttribute($produit, 'libele','categorie')}}</td>
                                    <td>{{Warehouse::getModelAttribute($produit, 'libele','marque')}}</td>
                                    <td>{{$produit->prix}} F. CFA</td>
                                    <td>

                                        <form action="{{route('produit.destroy',$produit -> id)}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <a href="{{route('produit.edit',$produit -> id)}}" class="btn btn-outline-success"><i
                                                    class="fas fa-pen ml-2"></i>edit</a>
                                            <button type="submit" class="btn btn-outline-warning"><i
                                                    class="fas fa-minus-circle ml-2"></i>delete</button>
                                        </form>
                                    </td>
                                    <td>{{Warehouse::getModelAttribute($produit, 'etablissement','fournisseur')}}</td>
                                    <td>{{$produit -> description}}</td>
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


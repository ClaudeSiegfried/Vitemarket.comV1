@extends('adminlte::page')

@section('content')
    @include('partials.PreviousButton')

    <div class="accordion container-fluid align-items-center justify-content-between w-100 mh-75 p-0"
         id="accordionExample1">
        <div class="container-fluid row align-items-center justify-content-between w-100 mh-75 mt-1">
            <div class="col-sm-12 p-4 border-left " id="TableTable"
                 type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true"
                 aria-controls="collapseThree">
                <h4 class=" text-muted">Categories list
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
                            <a href="{{route('categorie.create')}}" class="btn btn-success btn-morphing rounded-pill float-right mb-4"> <i
                                    class="fas fa-plus mr-2"></i>Create a category</a>
                        </div>
                    </div>

                    @if ($categories->isEmpty())
                        <div class="container-fluid justify-content-center">
                            <p class="h4 text-muted">Vous n'avez pas encore enregistrer d'etiquette</p>
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
                                <th scope="col">DESCRIPTION</th>
                                <th scope="col">ACTIONS</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($categories as $categorie)
                                <tr>
                                    <td>
                                        <img class="img-thumbnail rounded-circle object-fit"
                                             @if (!empty($path = (implode($categorie->photo()->get()->pluck('path')->toArray()))))
                                             {{$route = route('photo.display', $path)}}
                                             @else
                                             {{$route = asset('custom/assets/ViteMarket/1.5x/ViteMarket - Asset 1hdpi.png')}}
                                             {{--{{dd($path)}}--}}
                                             @endif
                                             src="{{$route}}"
                                             alt="">
                                    </td>
                                    <td>{{$categorie -> libele}}</td>
                                    <td>{{$categorie -> description}}</td>
                                    <td>
                                        @can('manage-users')
                                            <form action="{{route('categorie.destroy',$categorie -> id)}}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <a href="{{route('categorie.edit',$categorie -> id)}}" class="btn btn-outline-success"><i
                                                        class="fas fa-pen ml-2"></i>edit</a>
                                                <button type="submit" class="btn btn-outline-warning"><i
                                                        class="fas fa-minus-circle ml-2"></i>delete</button>
                                            </form>
                                        @endcan
                                    </td>
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


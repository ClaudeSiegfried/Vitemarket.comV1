@extends('adminlte::page')

@section('content')
    @include('partials.PreviousButton')

    {{--    <div class="container-fluid row">
            <div class="col-12">
                <a href="{{route('commande.create')}}" class="btn btn-success btn-morphing rounded-pill float-right mb-4"> <i
                        class="fas fa-plus mr-2"></i>Create a order</a>
            </div>
        </div>--}}
    {{--
    {{dd($commandes)}}
    --}}

    <table class="table table-hover table-head-fixed table-responsive-sm overflow-hidden nowrap"
           id="tableau"
           data-toggle="tableau"
    >
        <thead>
        <tr>
            <th scope="col">LOCALISATION</th>
            <th scope="col">CLIENT</th>
            <th scope="col">CODE</th>
            <th scope="col">STATUT</th>
            <th scope="col">PRODUITS</th>
            <th scope="col">ACTIONS</th>
        </tr>
        </thead>
        <tbody>

        @foreach($commandes as $commande)
            <tr>
                <td class="align-items-center row-cols">
                    <button type="submit" class="btn btn-toolbar"><i
                            class="fas fa-map-marker-alt ml-2"></i>
                    </button>
                    <p>{{$commande -> localisation}}</p>
                </td>
                <td>{{$commande -> client}}</td>
                <td>{{$commande -> code_commande}}</td>
                <td>
                    <span class="badge badge-info badge-success">
                        {{$commande -> statut}}
                    </span>
                </td>
                <td>
                    @foreach($commande ->panier as $panier)
                        <span class="badge">
                        <img class="img-thumbnail rounded-circle object-fit table-avatar"
                             @if (!empty($path = ($panier->produit->path)))
                             {{$route = $path}}
                             @else
                             {{$route = asset('custom/assets/ViteMarket/1.5x/ViteMarket - Asset 1hdpi.png')}}
                             {{--{{dd($path)}}--}}
                             @endif
                             src="{{$route}}"
                             alt="">
                        <span class="badge badge-info badge-success">
                        {{$panier->quantite}}
                        </span>
                    </span>

                    @endforeach
                </td>
                <td>
                    @can('manage-users')
                        <a href="{{route('commande.show',$commande -> id)}}" class="btn btn-outline-success"><i
                                class="fas fa-eye ml-2"></i></a>
                        <form action="{{route('commande.destroy',$commande)}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-warning"><i
                                    class="fas fa-minus-circle ml-2"></i></button>
                        </form>
                    @endcan
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection


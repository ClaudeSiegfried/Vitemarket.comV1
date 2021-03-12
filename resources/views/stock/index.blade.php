@extends('adminlte::page')

@section('content')

    @include('partials.PreviousButton')
    <table class="table table-hover table-head-fixed table-responsive-sm overflow-hidden nowrap"
           id="tableau"
           data-toggle="tableau"
    >
        <thead>
             <tr>
            <th scope="col">IMAGE</th>
            <th scope="col">PRODUIT</th>
            <th scope="col">PRIX</th>
            <th scope="col">QUANTITE PHYSIQUE</th>
            <th scope="col">QUANTITE PRE - DEBITE</th>
            <th scope="col">QUANTITE FACTUREE</th>
            <th scope="col">CATEGORIE</th>
            <th scope="col">MARQUE</th>
            <th scope="col">ACTIONS</th>
            <th scope="col">DATE D'EXPIRATION</th>
            <th scope="col">DESCRIPTION</th>
        </tr>
        </thead>

        <tbody>

        @foreach($stocks as $produit)
            <tr>
                <td>
                    <img class="img-thumbnail rounded-circle object-fit"
                         @if (!empty($path = ($produit->path)))
                         {{$route = $path}}
                         @else
                         {{$route = asset('custom/assets/ViteMarket/1.5x/ViteMarket - Asset 1hdpi.png')}}
                         @endif
                         src={{$route}}
                     alt="">
                </td>
                <td>{{$produit->Libele}}</td>
                <td>{{$produit->prix}} F. CFA</td>
                <td>{{$produit->quantite_physique}}</td>
                <td>{{$produit->quantite_predebite}}</td>
                <td>{{$produit->quantite_facture}}</td>
                <td>{{$produit->categorie}}</td>
                <td>{{$produit->marque}}</td>
                <td>
                    <a href="{{route('produit.edit',$produit -> produit_id)}}" class="btn btn-outline-success"><i
                                class="fas fa-pen ml-2"></i></a>

                    <form action="{{route('stock.destroy',$produit -> id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-warning disabled"><i
                                    class="fas fa-minus-circle ml-2"></i></button>
                    </form>
                </td>
                <td>{{$produit->date_de_peremption}}</td>
                <td><p>{{$produit -> description}}</p></td>
            </tr>
        @endforeach

        </tbody>
    </table>


@endsection

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
    {{dd($paiements)}}
--}}

    <table class="table table-hover table-head-fixed table-responsive-sm overflow-hidden nowrap"
           id="tableau"
           data-toggle="tableau"
    >
        <thead>
        <tr>
            <th scope="col">ID COMMANDE</th>
            <th scope="col">CLIENT</th>
            <th scope="col">METHODE DE PAIEMENT</th>
            <th scope="col">MONTANT</th>
            <th scope="col">STATUT</th>
        </tr>
        </thead>
        <tbody>
        @foreach($paiements as $paiement)
            <tr>
                <td>{{$paiement -> commande_id}}</td>
                <td>{{$paiement -> client}}</td>
                <td>{{$paiement -> mmoney}}</td>
                <td>{{$paiement -> montant}}</td>
                <td>{{$paiement -> statut}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection


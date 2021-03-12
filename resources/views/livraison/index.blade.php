@extends('adminlte::page')

@section('content')
    @include('partials.PreviousButton')

    {{--
        <div class="container-fluid row">
            <div class="col-12">
                <a href="{{route('commande.create')}}" class="btn btn-success btn-morphing rounded-pill float-right mb-4"> <i
                        class="fas fa-plus mr-2"></i>Create a order</a>
            </div>
        </div>
    --}}
    {{--
        {{dd($Deliveries)}}
    --}}

    <table class="table table-hover table-head-fixed table-responsive-sm overflow-hidden nowrap"
           id="tableau"
           data-toggle="tableau"
    >
        <thead>
        <tr>
            <th scope="col">LOCALISATION</th>
            <th scope="col">LIVREUR</th>
            <th scope="col">CLIENT</th>
            <th scope="col">STATUT</th>
            <th scope="col">ACTIONS</th>
        </tr>
        </thead>
        <tbody>
        @foreach($Deliveries as $Delivery)
            <tr>
                {{--
                                <td>
                                    <img class="img-thumbnail rounded-circle object-fit"
                                         @if (!empty($path = (implode($categorie->photo()->get()->pluck('path')->toArray()))))
                                         {{$route = route('photo.display', $path)}}
                                         @else
                                         {{$route = asset('custom/assets/ViteMarket/1.5x/ViteMarket - Asset 1hdpi.png')}}

                                         @endif
                                         src="{{$route}}"
                                         alt="">
                                </td>
                --}}
                <td class="align-items-center row-cols">
                    <button type="submit" class="btn btn-toolbar"><i
                            class="fas fa-map-marker-alt ml-2"></i>
                    </button>
                    <p>{{$Delivery -> localisation}}</p>
                </td>
                <td>{{$Delivery -> livreur}}</td>
                <td>{{$Delivery -> client}}</td>
                <td>
                    <span class="badge badge-info badge-light">
                    {{$Delivery -> statut}}
                    </span>
                </td>
                <td>
                    @can('manage-users')
                        <a href="{{route('livraison.edit',$Delivery -> id)}}" class="btn btn-outline-success"><i
                                class="fas fa-pen ml-2"></i></a>
                        <form action="{{route('livraison.destroy',$Delivery -> id)}}" method="post">
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

@section('right-sidebar')
    <div id="map"></div>
@endsection

@section('js')
    <script>
        // Initialize and add the map
        function initMap() {
            // The location of Uluru
            var uluru = {lat: -25.344, lng: 131.036};
            // The map, centered at Uluru
            var map = new google.maps.Map(
                document.getElementById('map'), {zoom: 5, center: uluru});
            // The marker, positioned at Uluru
            var marker = new google.maps.Marker({position: uluru, map: map});
        }
    </script>
    <script defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCSs0K7_L0-0vk4OhXYYxA46fLYTov7dxA&callback=initMap">
    </script>

@stop

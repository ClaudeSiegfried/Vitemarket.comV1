@extends('adminlte::page')

@section('content')
    @include('partials.PreviousButton')

    <table class="table table-hover table-head-fixed table-responsive-sm overflow-hidden nowrap"
           id="tableau"
           data-toggle="tableau"
    >
        <thead>
        <tr>
            <th scope="col">IMG</th>
            <th scope="col">NOM</th>
            <th scope="col">MAIL</th>
            <th scope="col">TEL</th>
            <th scope="col">AVAILABILITY</th>
            <th scope="col">ACTIONS</th>
        </tr>
        </thead>
        <tbody>
        @foreach($livreurs as $livreur)
            <tr>
                <td>
                    <img class="img-thumbnail rounded-circle object-fit"
                         @if (!empty($path = (implode($livreur->photo()->get()->pluck('path')->toArray()))))
                         {{$route = route('photo.display', $path)}}
                         @else
                         {{$route = asset('custom/assets/ViteMarket/1.5x/ViteMarket - Asset 1hdpi.png')}}
                         {{--{{dd($path)}}--}}
                         @endif
                         src="{{$route}}"
                         alt="">
                </td>
                <td>{{implode($livreur ->user() ->get()->pluck('name')->toArray())}}</td>
                <td>{{implode($livreur ->user() ->get()->pluck('email')->toArray())}}</td>
                <td>{{implode($livreur ->user() ->get()->pluck('tel')->toArray())}}</td>
                <td>
                    @if ($livreur->dispo)
                        <a href="#" class="badge badge-info">Available</a>
                    @else
                        <a href="#" class="badge badge-danger">busy</a>
                    @endif
                </td>
                <td>
                    @can('manage-users')

                        <form action="{{route('admin.users.destroy',$livreur -> id)}}" method="post">
                            @csrf
                            @method('DELETE')
                            <a href="{{route('admin.users.edit',$livreur -> id)}}" class="btn btn-outline-success"><i
                                    class="fas fa-pen ml-2"></i>edit</a>
                            <button type="submit" class="btn btn-outline-warning"><i
                                    class="fas fa-minus-circle ml-2"></i>unsuscribe role</button>
                        </form>
                    @endcan
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection


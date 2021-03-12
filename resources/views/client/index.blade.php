@extends('adminlte::page')

@section('content')
    @include('partials.PreviousButton')

    <table class="table table-hover table-head-fixed table-responsive-sm overflow-hidden nowrap"
           id="tableau"
           data-toggle="tableau"
    >
        <thead>
        <tr>
            <th scope="col">PHOTO</th>
            <th scope="col">NOM</th>
            <th scope="col">MAIL</th>
            <th scope="col">TEL</th>
            <th scope="col">ACTIONS</th>
        </tr>
        </thead>
        <tbody>
        @foreach($clients as $client)

            <tr>
                <td>
                    <img class="img-thumbnail rounded-circle object-fit"
                         @if (!empty($path = (implode($client->photo()->get()->pluck('path')->toArray()))))
                         {{$route = route('photo.display', $path)}}
                         @else
                         {{$route = asset('custom/assets/ViteMarket/1.5x/ViteMarket - Asset 1hdpi.png')}}
                         {{--{{dd($path)}}--}}
                         @endif
                         src="{{$route}}"
                         alt="">
                </td>
                <td>{{implode($client ->user() ->get()->pluck('name')->toArray())}}</td>
                <td>{{implode($client ->user() ->get()->pluck('email')->toArray())}}</td>
                <td>{{implode($client ->user() ->get()->pluck('tel')->toArray())}}</td>
                <td>
                    @can('manage-users')

                        <form action="{{route('client.destroy',$client -> id)}}" method="post">
                            @csrf
                            @method('DELETE')
                            <a href="{{route('admin.users.edit',$client -> user_id)}}" class="btn btn-outline-success"><i
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


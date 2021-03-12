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
                        <th scope="col">ROLE</th>
                        <th scope="col">TEL</th>
                        <th scope="col">ACTIONS</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>
                                <img class="img-thumbnail rounded-circle object-fit"
                                     @if (!empty($path = (implode($user->photo()->get()->pluck('path')->toArray()))))
                                     {{$route = route('photo.display', $path)}}
                                     @else
                                     {{$route = asset('custom/assets/ViteMarket/1.5x/ViteMarket - Asset 1hdpi.png')}}
                                     {{--{{dd($path)}}--}}
                                     @endif
                                     src="{{$route}}"
                                     alt="">
                            </td>                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{implode(' | ',$user->roles()->get()->pluck('name')->toArray())}}</td>
                            <td>{{$user->tel}}</td>
                            <td>
                                @can('manage-users')

                                    <form action="{{route('admin.users.destroy',$user -> id)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <a href="{{route('admin.users.edit',$user -> id)}}" class="btn btn-outline-success"><i
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

@endsection

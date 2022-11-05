@extends('layouts.app-master')

@section('content')
    <div class="bg-light p-5 rounded">
        @auth
        <h1>Dashboard</h1>
        <p class="lead">Only authenticated users can access this section.</p>
        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        {{-- <form method="POST" action="{{ route('home.store') }}" class="mb-5">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <h1 class="h3 mb-3 fw-normal">Add settings</h1>

            <div class="form-group form-floating mb-3">
                <input type="text" class="form-control" name="hasActiveNotifications" value="1" placeholder="Has active notifications">
            </div>

            <button class="w-100 btn btn-lg btn-primary" type="submit">Submit</button>
        </form> --}}

        <h1 class="h3 mb-3 fw-normal">Settings</h1>
        <table class="table table-bordered">
            <tr>
                <th>No</th>
                <th>Id</th>
                <th>Has active notifications</th>
                <th width="280px">Action</th>
            </tr>
            @foreach ($user_settings as $setting)
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $setting->id }}</td>
                <td>{{ $setting->hasActiveNotifications }}</td>
                <td>
                    {{-- <form>
                        <a class="btn btn-primary" href="{{ route('home.index',$setting->id) }}">Edit</a>
                    </form> --}}
                    <form action="{{ route('home.update', $setting->id) }}" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <input type="hidden" name="id" value="{{ $setting->id }}">
                        @method('PUT')

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" @if($setting->hasActiveNotifications == "on") checked @endif name='hasActiveNotifications' id="hasActiveNotifications">
                            <label class="form-check-label" for="hasActiveNotifications">
                              Active notifications
                            </label>
                          </div>

                        <button class="w-100 mt-3 btn  btn-primary" type="submit">Submit</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
        @endauth

        @guest
        <h1>Homepage</h1>
        <p class="lead">Your viewing the home page. Please login to view the restricted data.</p>
        @endguest
    </div>
@endsection

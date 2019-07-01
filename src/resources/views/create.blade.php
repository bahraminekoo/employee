@extends('paloit::layouts.app')
@section('title', 'Add New Employee')
@section('content')
    <section class="section section-add-employee">
        <div class="text-center"><h5>{{__('paloit::messages.add_new_employee')}}</h5></div>
        <form action="{{url('/employees')}}" method="post">
            @csrf
            <div class="form-group">
                <label for="employee-name">{{__('paloit::messages.name')}}</label>
                <input name="name" type="text" class="form-control" placeholder="{{__('paloit::messages.name')}}"
                       id="employee-name" value="{{ old('name') }}"/>
                @if ($errors->has('name'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group">
                <label for="employee-email">{{__('paloit::messages.email')}}</label>
                <input name="email" type="email" class="form-control" placeholder="{{__('paloit::messages.email')}}"
                       id="employee-email" value="{{ old('email') }}" />
                @if ($errors->has('email'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group">
                <label for="employee-doe">{{__('paloit::messages.doe')}}</label>
                <input name="doe" type="date" class="form-control" placeholder="{{__('paloit::messages.doe')}}"
                       id="employee-doe" value="{{ old('doe') }}" />
                @if ($errors->has('doe'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('doe') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group">
                <label for="employee-manager">{{__('paloit::messages.manager')}}</label>
                <select name="manager_id" class="form-control" id="employee-manager" value="{{ old('manager_id') }}" >
                    @foreach($employees as $id => $name)
                        <option value="{{$id}}">{{$name}}</option>
                    @endforeach
                </select>
                @if ($errors->has('manager_id'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('manager_id') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group text-center">
                <button type="submit" class="btn btn-primary">{{__('paloit::messages.add')}}</button>
            </div>
        </form>
    </section>
@endsection
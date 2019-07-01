@extends('paloit::layouts.app')
@section('title', 'Edit Employee')
@section('content')
    <section class="section section-edit-employee">
        <div class="text-center"><h5>{{__('paloit::messages.edit_employee')}}</h5></div>
        <form action="{{url('/employees/'.$employee->getKey())}}" method="post">
            @csrf
            {{ method_field('PUT') }}
            <div class="form-group">
                <label for="employee-name">{{__('paloit::messages.name')}}</label>
                <input name="name" type="text" class="form-control" placeholder="{{__('paloit::messages.name')}}"
                       id="employee-name" value="{{ old('name', $employee->name ) }}"/>
                @if ($errors->has('name'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group">
                <label for="employee-email">{{__('paloit::messages.email')}}</label>
                <input name="email" type="email" class="form-control" placeholder="{{__('paloit::messages.email')}}"
                       id="employee-email" value="{{ old('email', $employee->email ) }}" />
                @if ($errors->has('email'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group">
                <label for="employee-doe">{{__('paloit::messages.doe')}}<span> - prev : {{$employee->doe->format('Y-m-d')}}</span></label>
                <input name="doe" type="date" class="form-control" placeholder="{{__('paloit::messages.doe')}}"
                       id="employee-doe" value="{{ old('doe', $employee->doe->format('Y-m-d') ) }}" />
                @if ($errors->has('doe'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('doe') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group">
                <label for="employee-manager">{{__('paloit::messages.manager')}}</label>
                <select name="manager_id" class="form-control" id="employee-manager" value="{{ old('manager_id', $employee->manager_id) }}" >
                    @foreach($employees as $id => $name)
                        @if($id == $employee->getKey())
                            @continue
                        @endif
                        @php($selected = '')
                        @if($id == $employee->manager_id)
                            @php($selected = 'selected')
                        @endif
                        <option value="{{$id}}" {{$selected}}>{{$name}}</option>
                    @endforeach
                </select>
                @if ($errors->has('manager_id'))
                    <span class="invalid-feedback">
                        <strong>{{ $errors->first('manager_id') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group text-center">
                <button type="submit" class="btn btn-primary">{{__('paloit::messages.edit')}}</button>
            </div>
        </form>
    </section>
@endsection
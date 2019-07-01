@extends('paloit::layouts.app')
@section('title', 'Employees Grid')
@section('content')
    @if(@$is_search_result)
        <div class="alert alert-success">
            {{$message}}
        </div>
    @endif
    @if ($errors->has('start_date'))
        <div class="alert alert-danger">
            {{ $errors->first('start_date') }}
        </div>
    @endif
    @if ($errors->has('end_date'))
        <div class="alert alert-danger">
            {{ $errors->first('end_date') }}
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <section class="section section-grid">
        <div class="container-fluid">
            @if(!@$is_manager_employees)
                <div class="row">
                    <div class="col">
                        <button type="button" class="btn btn-primary" id="show_grid_filters">Filters</button>
                    </div>
                </div>
            <div class="row">
                <div class="col">&nbsp;</div>
            </div>
                <div class="row hidden-filters">
                    <div class="col">

                        <form method="post" action="{{ url('/search')  }}" id="grid-filters">
                            @csrf
                            <div class="form-row">
                                <div class="col">
                                    <label>{{__('paloit::messages.start_date')}}</label><input type="date"
                                                                                               name="start_date"
                                                                                               placeholder="start date"/>
                                </div>
                                <div class="col">
                                    <label>{{__('paloit::messages.end_date')}}</label><input type="date"
                                                                                             name="end_date"
                                                                                             placeholder="end date"/>
                                </div>
                                <div class="col">
                                    <button type="submit" class="btn btn-outline-info btn-sm">Apply Filters</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row" id="add-new-container">
                    <div class="col">
                        <a href="{{ url('/employees/create') }}"
                           class="btn btn-primary">{{__('paloit::messages.add_new_employee')}}</a>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col">
                        <h5>{{__('paloit::messages.employees_list_for_manager') . ' : ' . $manager->name}}</h5>
                    </div>
                </div>
            @endif
            <div class="row grid-header">
                 <div class="col flex-center valign-middle font-10 col-remove">
                    {{__('paloit::messages.name')}}
                </div>
                <div class="col-3 col-sm flex-center valign-middle font-10">
                    {{__('paloit::messages.email')}}
                </div>
                <div class="col flex-center valign-middle font-10 col-remove">
                    {{__('paloit::messages.doe')}}
                </div>
                <div class="col col-sm flex-center valign-middle font-10">
                    {{__('paloit::messages.manager')}}
                </div>
                <div class="col-2 col-sm flex-center valign-middle font-10">
                    {{__('paloit::messages.actions')}}
                </div>
            </div>
            @foreach($employees as $index => $employee)
                <div class="row grid-row">
                    <div class="col flex-center valign-middle font-10 col-remove">
                        {{$employee->name}}
                    </div>
                    <div class="col-3 col-sm flex-center valign-middle font-10">
                        {{$employee->email}}
                    </div>
                    <div class="col flex-center valign-middle font-10 col-remove">
                        {{$employee->doe->format('Y-m-d')}}
                    </div>
                    <div class="col col-sm flex-center valign-middle font-10">
                        @if(!is_null($employee->manager))
                            {{$employee->manager->name}}
                        @endif
                    </div>
                    <div class="col-2 col-sm flex-center valign-middle font-10">
                        <a title="{{__('paloit::messages.view')}}" id="employee_view_{{$employee->getKey()}}"
                           data-employee-id="{{$employee->getKey()}}" href="">{{__('paloit::messages.view')}}</a>
                        |
                        <a title="{{__('paloit::messages.edit')}}"
                           href="{{url('/employees/'.$employee->getKey().'/edit')}}">{{__('paloit::messages.edit')}}</a>
                        |
                        <form id="employee-delete-form-{{$employee->getKey()}}"
                              action="{{url('/employees', ['id' => $employee->getKey()])}}" method="post">
                            @method('delete')
                            @csrf
                        </form>
                        <a title="{{__('paloit::messages.del')}}" data-employee-id="{{$employee->getKey()}}"
                           id="employee-delete-{{$employee->getKey()}}" href="">{{__('paloit::messages.del')}}</a>
                        @if($employee->employees()->count())
                            |
                            <a title="{{__('paloit::messages.employees')}}"
                               href="{{url('/manager/'.$employee->getKey().'/employees')}}">{{__('paloit::messages.employees')}}</a>
                        @endif
                    </div>
                    <div id="employee_modal_{{$employee->getKey()}}" class="modal"
                         data-employee-id="{{$employee->getKey()}}">
                        <div class="modal-content">
                            <span id="employee_modal_close_{{$employee->getKey()}}" class="close"
                                  data-employee-id="{{$employee->getKey()}}">&times;</span>
                            <div class="container-fluid">
                                <div class="row grid-row">
                                    <div class="col-3 valign-middle">
                                        {{__('paloit::messages.name')}} :
                                    </div>
                                    <div class="col valign-middle">
                                        {{$employee->name}}
                                    </div>
                                </div>
                                <div class="row grid-row">
                                    <div class="col-3 valign-middle">
                                        {{__('paloit::messages.email')}} :
                                    </div>
                                    <div class="col valign-middle">
                                        {{$employee->email}}
                                    </div>
                                </div>
                                <div class="row grid-row">
                                    <div class="col valign-middle">
                                        {{__('paloit::messages.doe')}} :
                                    </div>
                                    <div class="col valign-middle">
                                        {{$employee->doe->format('Y-m-d')}}
                                    </div>
                                </div>
                                <div class="row grid-row">

                                    <div class="col-3 valign-middle">
                                        {{__('paloit::messages.manager')}} :
                                    </div>
                                    <div class="col valign-middle">
                                        @if(!is_null($employee->manager))
                                            {{$employee->manager->name}}
                                        @else
                                            {{__('paloit::messages.none')}}
                                        @endif
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach

        </div>
    </section>
    <section class="section section-pagination">
        @if(!@$is_manager_employees && !@$is_search_result)
            {{$employees->links()}}
        @endif
    </section>
@endsection


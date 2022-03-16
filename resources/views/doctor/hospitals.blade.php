@extends('layouts.app')

@section('content')
    <div class="container">

        <div
            class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">

            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-2">
                        <div class="p-6">
                            <div class="flex items-center">
                                المستشفيات
                            </div>
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">name</th>
                                    <th scope="col">address</th>
                                    <th scope="col">الاجراءات</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(isset($hospitals) && $hospitals->count() > 0)
                                    @foreach($hospitals as $hospital)
                                        <tr>
                                            <th scope="row">{{$hospital->id}}</th>
                                            <td>{{$hospital->name}}</td>
                                            <td>{{$hospital->address}}</td>
                                            <td>
                                                <a href="{{route('hospitalDoctor',$hospital->id)}}" class="btn btn-success">عرض الاطباء</a>
                                                <a href="{{route('hospitalDelete',$hospital->id)}}" class="btn btn-danger">حذف</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@stop

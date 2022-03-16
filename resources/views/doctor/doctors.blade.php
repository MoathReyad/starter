@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">

            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-2">
                        <div class="p-6">
                            <div class="flex items-center">
                              الاطباء
                            </div>
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">name</th>
                                    <th scope="col">title</th>
                                    <th scope="col">operations</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(isset($doctors) && $doctors->count() > 0)
                                    @foreach($doctors as $doctor)
                                        <tr>
                                            <th scope="row">{{$doctor->id}}</th>
                                            <td>{{$doctor->name}}</td>
                                            <td>{{$doctor->title}}</td>
                                            <td>
                                                <a href="{{route('doctorServices',$doctor->id)}}" class="btn btn-success">عرض الخدمات</a>
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

@section('script')
    <script>
        $(document).on('click', '#save_offer', function (e) {
            e.preventDefault();
            var formData = new FormData($('#offerForm')[0]);
            $.ajax({
                type: 'post',
                enctype: 'multipart/form-data', // Use it when I want to upload a file (photo, video, PDF,.........)
                url: "{{route('ajaxOffersStore')}}",
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function (data) {
                    if (data.status == true)
                       $('#success_msg').show();
                },
                error: function (reject) {
                    //
                }
            });
        });
    </script>
@stop

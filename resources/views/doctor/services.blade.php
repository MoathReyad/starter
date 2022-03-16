@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">

            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-2">
                        <div class="p-6">
                            <div class="flex items-center">
                              الخدمات
                            </div>
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">name</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(isset($services) && $services->count() > 0)
                                    @foreach($services as $service)
                                        <tr>
                                            <th scope="row">{{$service->id}}</th>
                                            <td>{{$service->name}}</td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                            <br><br>

                            <form method="POST" action="{{route('save.services.to.Doctor')}}" enctype="multipart/form-data">

                                @csrf
                                {{-- <input name="_token" value="{{csrf_token()}}"> --}}


                                <div class="form-group">
                                    <label for="exampleInputEmail1">اختر طبيب</label>
                                    <select class="form-control" name="doctor_id">
                                        @if(isset($doctors) && $doctors->count() > 0)
                                            @foreach($doctors as $doctor)
                                                <option value="{{$doctor->id}}">{{$doctor->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">اختر الخدمات</label>
                                    <select class="form-control" name="services_id[]" multiple>
                                        @if(isset($allServices) && $allServices->count() > 0)
                                            @foreach($allServices as $allService)
                                                <option value="{{$allService->id}}">{{$allService->name}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">{{__('messages.Save Offer')}}</button>
                            </form>

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

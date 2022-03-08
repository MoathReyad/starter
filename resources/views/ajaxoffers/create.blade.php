@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">

            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                    <div class="grid grid-cols-1 md:grid-cols-2">
                        <div class="p-6">
                            <div class="flex items-center">
                                <h1>Add offers details</h1>
                            </div>

                            <div class="ml-12">
                                @if(Session::has('success'))
                                    <div class="alert alert-success" role="alert">
                                        {{Session::get('success')}}
                                    </div><br>
                                @endif
                                <diV class="alert alert-success" id="success_msg" style="display: none;">
                                    تم الحفظ بنجاح
                                </diV>
                                <form method="POST" id="offerForm" action="" enctype="multipart/form-data">

                                    @csrf
                                    {{-- <input name="_token" value="{{csrf_token()}}"> --}}

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">أختر صوره العرض</label>
                                        <input type="file" class="form-control" name="photo">
                                        @error('photo')
                                        <small class="form-text text-danger">{{$message}}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">{{__('messages.Offer Name ar')}}</label>
                                        <input type="text" class="form-control" name="name_ar"
                                               placeholder="{{__('messages.Offer Name')}}">
                                        @error('name_ar')
                                        <small class="form-text text-danger">{{$message}}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">{{__('messages.Offer Name en')}}</label>
                                        <input type="text" class="form-control" name="name_en"
                                               placeholder="{{__('messages.Offer Name')}}">
                                        @error('name_en')
                                        <small class="form-text text-danger">{{$message}}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputPassword1">{{__('messages.Offer Price')}}</label>
                                        <input type="text" class="form-control" name="price"
                                               placeholder="{{__('messages.Offer Price')}}">
                                        @error('price')
                                        <small class="form-text text-danger">{{$message}}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputPassword1">{{__('messages.Offer details ar')}}</label>
                                        <input type="text" class="form-control" name="details_ar"
                                               placeholder="{{__('messages.Offer details')}}">
                                        @error('details_ar')
                                        <small class="form-text text-danger">{{$message}}</small>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputPassword1">{{__('messages.Offer details en')}}</label>
                                        <input type="text" class="form-control" name="details_en"
                                               placeholder="{{__('messages.Offer details')}}">
                                        @error('details_en')
                                        <small class="form-text text-danger">{{$message}}</small>
                                        @enderror
                                    </div>

                                    <button id="save_offer"
                                            class="btn btn-primary">{{__('messages.Save Offer')}}</button>
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

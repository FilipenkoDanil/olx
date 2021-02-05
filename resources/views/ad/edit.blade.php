@extends('layouts.app')

@section('title', 'Редактирование объявления')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-xl-12">
                @if(session()->has('warning'))
                    <div class="alert alert-danger text-center" role="alert">
                        {{ session()->get('warning') }}
                    </div>
                @endif
                <div class="card-box">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="col-md-12">
                        <form method="POST" action="{{ route('ad.update', $ad) }}" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf
                            <div class="form-group">
                                <label for="title">Название объявления</label>
                                <input type="text" id="title" name="title" class="form-control"
                                       placeholder="Введите название" value="{{ $ad->title }}">
                            </div>

                            <div class="form-group">
                                <label for="description">Описание</label>
                                <textarea class="form-control" id="description" name="description"
                                          placeholder="Описание Вашего товара (необязательно)">{{ $ad->description }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="price">Цена в грн.</label>
                                <input type="number" id="price" name="price" class="form-control"
                                       placeholder="Введите цену" value="{{ $ad->price }}">
                            </div>

                            <div class="form-group">
                                <label>Город</label>
                                <select class="form-control" name="city_id">
                                    @foreach($cities as $city)
                                        <option @if($ad->city->id === $city->id) selected
                                                @endif value="{{ $city->id }}">{{ $city->city }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="input">Выберите фото (одно или несколько):</label>
                                <input class="form-control-file" id="input" type="file" name="image[]" multiple
                                       accept=".jpg, .jpeg, .png"/>
                            </div>

                            <button type="submit" class="btn btn-primary">Внести изменения</button>
                        </form>
                        <hr>
                        @foreach($ad->images as $image)
                            <div role="group" class=" col-md-12"><img
                                    src="{{ Storage::url($image->image) }}"
                                    class="d-sm-inline"
                                    style="width: 200px; border-radius: 10px; margin: 10px 10px 0px 0px">
                                <form method="post" action="{{ route('image.delete', $image) }}"
                                      style="display: inline-block;"><a href="#">
                                        <button type="submit" class="btn btn-danger">Удалить</button>
                                    </a>
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <hr>
                            </div>
                        @endforeach
                    </div>
                </div> <!-- end card-box-->

            </div> <!-- end col -->
        </div>
    </div>
@endsection

@section('custom_js')
    @include('scripts.pusher')
@endsection

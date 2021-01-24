@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-xl-12">
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
                        <form method="POST" action="{{ route('create.ad') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="title">Название обявления</label>
                                <input type="text" id="title" name="title" class="form-control" placeholder="Введите название" value="{{ old('title') }}">
                            </div>

                            <div class="form-group">
                                <label for="description">Описание</label>
                                <textarea class="form-control" id="description" name="description" placeholder="Описание Вашего товара (необязательно)">{{ old('description') }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="price">Цена в грн.</label>
                                <input type="number" id="price" name="price" class="form-control" placeholder="Введите цену" value="{{ old('price') }}">
                            </div>

                            <div class="form-group">
                                <label for="input">Выберите фото (одно или несколько):</label>
                                <input class="form-control-file" id="input" type="file" name="image[]" multiple accept=".jpg, .jpeg, .png"/>
                            </div>

                            <button type="submit" class="btn btn-primary">Создать объявление</button>
                        </form>
                    </div>
                </div> <!-- end card-box-->

            </div> <!-- end col -->
        </div>
    </div>
@endsection

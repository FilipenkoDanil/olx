@extends('layouts.app')

@section('title', 'Настройки профиля')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-xl-4">
                <div class="card-box text-center">
                    <img src="{{ Storage::url($user->avatar) }}"
                         class="rounded-circle avatar-xl img-thumbnail" alt="profile-image">
                    <h4 class="mb-0">{{ $user->name }}</h4>

                    <div class="text-left mt-3">
                        @if(!is_null($user->about))
                            <h4 class="font-13 text-uppercase">Обо мне :</h4>
                            <p class="text-muted font-13 mb-3">
                                {{ $user->about }}
                            </p>
                        @endif

                        <p class="text-muted mb-2 font-13"><strong>Телефон :</strong><span class="ml-2">{{ $user->phone }}</span></p>

                        <p class="text-muted mb-2 font-13"><strong>Почта :</strong> <span class="ml-2 ">{{ $user->email }}</span>
                        </p>

                    </div>

                </div> <!-- end card-box -->


            </div> <!-- end col-->

            <div class="col-lg-8 col-xl-8">
                <div class="card-box">
                    <ul class="nav nav-pills navtab-bg">

                        <li class="nav-item">
                            <a href="#settings" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                <i class="mdi mdi-settings-outline mr-1"></i>Настройки
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane active" id="settings">
                            <form action="{{ route('user.update', $user) }}" method="POST" enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-account-circle mr-1"></i>
                                    Информация</h5>

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="firstname">ФИО</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                   placeholder="Введите Фамилию и Имя" value="{{ $user->name }}" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="phone">Телефон</label>
                                            <input type="tel" class="form-control" id="phone" name="phone" placeholder="0981234567" value="{{ $user->phone }}"
                                                   required/>
                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->

                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="userbio">О себе</label>
                                            <textarea class="form-control" id="userbio" rows="4"
                                                      placeholder="Напишите что-нибудь.." name="about">{{ $user->about }}</textarea>
                                        </div>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="useremail">Email Адрес</label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                   placeholder="Введите email" value="{{ $user->email }}" required/>
                                        </div>
                                    </div>
                                </div> <!-- end row -->

                                <div class="form-group">
                                    <label for="input">Аватар:</label>
                                    <input class="form-control-file" id="input" type="file" name="avatar" accept=".jpg, .jpeg, .png"/>
                                </div>

                                <div class="text-right">
                                    <button type="submit" class="btn btn-success waves-effect waves-light mt-2"><i
                                            class="mdi mdi-content-save"></i> Сохранить
                                    </button>
                                </div>
                            </form>
                        </div>
                        <!-- end settings content-->

                    </div> <!-- end tab-content -->
                </div> <!-- end card-box-->

            </div> <!-- end col -->
        </div>
    </div>
@endsection

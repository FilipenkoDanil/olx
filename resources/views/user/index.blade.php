@extends('layouts.app')

@section('title', 'Профиль ' . $user->name)

@section('custom_js')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css" integrity="sha256-2XFplPlrFClt0bIdPgpz8H7ojnk10H69xRqd9+uTShA=" crossorigin="anonymous">
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-xl-3">
                <div class="card-box text-center">
                    <img src="{{ Storage::url($user->avatar) }}"
                         class="rounded-circle avatar-xl img-thumbnail" alt="profile-image">
                    <h4 class="mb-0">{{ $user->name }}</h4>
                    <p><span class="rating"><i
                                class="fa fa-star"></i></span>{{ $user->rating }}</p>
                    <div class="text-left mt-3">
                        @if(!is_null($user->about))
                            <h4 class="font-13 text-uppercase">Обо мне :</h4>
                            <p class="text-muted font-13 mb-3">
                                {{ $user->about }}
                            </p>
                        @endif

                        <p class="text-muted mb-2 font-13"><strong>Телефон :</strong><span
                                class="ml-2">{{ $user->phone }}</span></p>

                        <p class="text-muted mb-2 font-13"><strong>Почта :</strong> <span
                                class="ml-2 ">{{ $user->email }}</span>
                        </p>

                        <p class="text-muted text-center font-13"><a href="{{ route('user.ads', $user) }}"><strong>Все объявления</strong></a></p>
                    </div>
                </div> <!-- end card-box -->
            </div> <!-- end col-->

            <div class="col-lg-9 col-xl-9">
                <div class="card-box">
                    <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-account-circle mr-1"></i>
                        Отзывы о продавце</h5>

                    <div class="toch-table">
                        @forelse($user->reviews as $review)
                            <table class="table table-striped table-bordered">
                                <tbody>
                                <tr>
                                    <td><strong><a href="{{ route('user.profile', $review->writer) }}">{{ $review->writer->name }}</a></strong>
                                    </td>
                                    <td class="text-right">
                                        <div class="btn-block cart-put form-inline change">
                                            <strong>{{ $review->created_at->format('d/m/Y') }}</strong>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <p>{{ $review->comment }}</p>
                                        @for($i = 0; $i<5; $i++)
                                            @if($i < $review->rating)
                                                <span class="rating"><i
                                                        class="fa fa-star"></i></span>
                                            @else
                                                <span class="rating"><i
                                                        class="fa fa-star-o"></i></span>
                                            @endif
                                        @endfor
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        @empty
                            <h2 class="text-center">Здесь пока нет отзывов</h2>
                        @endforelse
                    </div>

                    <hr/>
                    @if($user->id !== Auth::id())
                        <div class="col-md-12">
                            <form action="{{ route('user.addreview', $user) }}" method="POST"
                                  enctype="multipart/form-data">
                                @csrf

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
                                    <div class="col-12">
                                        <div class="form-group">
                                            <h4>Оставить комментарий</h4>
                                            <textarea class="form-control" id="comment" name="comment" rows="4"
                                                      placeholder="Поделитесь впечатлениями: что понравилось, а что — не очень. В отзыве не должно быть оскорблений и мата."
                                            >{{ $user->about }}</textarea>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div
                                                    class="starrating risingstar d-flex justify-content-center flex-row-reverse">
                                                    <input type="radio" id="star5" name="rating" value="5"/><label
                                                        for="star5"
                                                        title="5 звезд"></label>
                                                    <input type="radio" id="star4" name="rating" value="4"/><label
                                                        for="star4"
                                                        title="4 звезды"></label>
                                                    <input type="radio" id="star3" name="rating" value="3"/><label
                                                        for="star3"
                                                        title="3 звезды"></label>
                                                    <input type="radio" id="star2" name="rating" value="2"/><label
                                                        for="star2"
                                                        title="2 звезды"></label>
                                                    <input type="radio" id="star1" name="rating" value="1"/><label
                                                        for="star1"
                                                        title="1 звезда"></label>
                                                </div>
                                            </div>
                                        </div> <!-- end row -->
                                    </div> <!-- end col -->
                                </div> <!-- end row -->

                                <div class="text-right">
                                    <button type="submit" class="btn btn-info waves-effect waves-light mt-2"><i
                                            class="mdi mdi-send"></i> Отправить
                                    </button>
                                </div>
                            </form>
                        </div>
                @endif
                <!-- end settings content-->
                </div> <!-- end card-box-->
            </div> <!-- end col -->
        </div>
    </div>
@endsection

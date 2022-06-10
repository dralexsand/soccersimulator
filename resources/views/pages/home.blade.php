@extends('layouts.master')

@section('title', 'Home')

@section('headerScripts')
    @parent
    <style>
        a {
            text-decoration: none;
        }
    </style>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-3">
            <button
                id="btn_simulate"
                type="button"
                class="btn btn-primary">
                Генерировать симуляцию
            </button>
        </div>
        <div class="col-md-3">
            <button
                id="btn_clear"
                type="button"
                class="btn btn-primary">
                Очистить данные
            </button>
        </div>
        <div class="col-md-6"></div>
    </div>

    <hr>

    @if(empty($data))
        <p>
            Нет данных
        </p>
    @else

        <table class="table table-hover">
            <thead>
            <tr>
                <th scope="col">Stadium</th>
                <th scope="col">Team 1</th>
                <th scope="col">Team 2</th>
                <th scope="col">Tablo</th>
                <th scope="col">View</th>
            </tr>
            </thead>
            <tbody>

            @foreach($data as $game)

                <tr>
                    <td>
                        {{ $game['stadium']->name }},
                        <br>
                        {{ $game['stadium']->capacity }}
                    </td>
                    <td>
                        {{ $game['team_1']->name }}
                    </td>
                    <td>
                        {{ $game['team_2']->name }}
                    </td>
                    <td>
                        {{ $game['goals_team_1'] }}:{{ $game['goals_team_2'] }}
                    </td>
                    <td>
                        <a href="{{ route('translation', ['id'=>$game['id']]) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-eye-fill" viewBox="0 0 16 16">
                                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                <path
                                    d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                            </svg>
                        </a>
                    </td>
                </tr>

            @endforeach


            </tbody>
        </table>

    @endif

@endsection

@section('footerScripts')
    @parent
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        $(function () {

            $('body').on('click', '#btn_simulate', function () {
                axios.get('api/v1/game/generate')
                    .then(function (response) {
                        // handle success
                        //console.log(response);
                        location.reload();
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    })
                    .then(function () {
                        // always executed
                    });
            });

            $('body').on('click', '#btn_clear', function () {
                axios.get('api/v1/game/clear')
                    .then(function (response) {
                        // handle success
                        //console.log(response);
                        location.reload();
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    })
                    .then(function () {
                        // always executed
                    });
            });

        });

    </script>

@endsection

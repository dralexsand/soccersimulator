@extends('layouts.master')

@section('title', 'Translation')

@section('headerScripts')
    @parent
@endsection

@section('content')
    <h1>Трансляция</h1>

    <hr>

    @if(empty($data))
        <p>
            Нет данных
        </p>
    @else

        <div class="row">
            <div class="col text-center">
                <h2 class="text-primary">
                    Стадион: {{ $data['stadium']->name }},
                    <br>
                    Вместительность: {{ $data['stadium']->capacity }}
                </h2>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col text-center">
                <h3> "{{ $data['team_1']->name }}" - "{{ $data['team_2']->name }}"</h3>
            </div>
        </div>

        <hr>

        <div class="row">
            <div class="col text-center">
                <h1> {{ $data['goals_team_1'] }}:{{ $data['goals_team_2'] }}</h1>
            </div>
        </div>

        <p>
            <button
                class="btn btn-primary"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target=".multi-collapse"
                aria-expanded="false"
                aria-controls="team_1 team_2">
                Состав команд:

                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                     class="bi bi-arrow-down-circle-fill" viewBox="0 0 16 16">
                    <path
                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V4.5z"/>
                </svg>

            </button>
        </p>
        <div class="row">

            <div class="col">
                <div class="collapse multi-collapse" id="team_1">
                    <div class="card card-body">

                        <table class="table table-hover table-striped">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Amplua</th>
                            </tr>
                            </thead>
                            <tbody>

                            @forelse($data['team_1_players'] as $player)

                                <tr>
                                    <th scope="row">
                                        {{ $player['jersey'] }}
                                    </th>
                                    <td>
                                        {{ $player['first_name'] }} {{ $player['last_name'] }}
                                    </td>
                                    <td>
                                        {{ $translates[$player['amplua']] }}
                                    </td>
                                </tr>

                            @empty
                                <p>Нет данных</p>
                            @endforelse

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

            <div class="col">
                <div class="collapse multi-collapse" id="team_2">
                    <div class="card card-body">

                        <table class="table table-hover table-striped">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Amplua</th>
                            </tr>
                            </thead>
                            <tbody>

                            @forelse($data['team_2_players'] as $player)

                                <tr>
                                    <th scope="row">
                                        {{ $player['jersey'] }}
                                    </th>
                                    <td>
                                        {{ $player['first_name'] }} {{ $player['last_name'] }}
                                    </td>
                                    <td>
                                        {{ $translates[$player['amplua']] }}
                                    </td>
                                </tr>

                            @empty
                                <p>Нет данных</p>
                            @endforelse

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <p>
                <button
                    class="btn btn-primary"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#translation_text"
                    aria-expanded="false"
                    aria-controls="collapseExample">
                    Трансляция матча

                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                         class="bi bi-arrow-down-circle-fill" viewBox="0 0 16 16">
                        <path
                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v5.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V4.5z"/>
                    </svg>
                </button>
            </p>
            <div
                class="collapse"
                id="translation_text">
                <div class="card card-body">

                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Time</th>
                            <th scope="col">Event</th>

                        </tr>
                        </thead>
                        <tbody>

                        @forelse($data['data'] as $game)

                            <tr>
                                <td>
                                    {{ $game['event_datetime'] }}
                                </td>
                                <td>
                                    {{ $game['message'] }}
                                </td>
                            </tr>
                        @empty
                            <p>Нет данных</p>
                        @endforelse

                        </tbody>
                    </table>

                </div>
            </div>
        </div>

    @endif

@endsection

@section('footerScripts')
    @parent
@endsection

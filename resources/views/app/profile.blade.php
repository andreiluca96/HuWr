@extends('layouts.app')

@section('assets')
    <link rel="stylesheet" type="text/css" href="{{asset('css/feed.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/profile.css')}}">
    <link
            rel="stylesheet"
            type="text/css"
            href="//cloud.github.com/downloads/lafeber/world-flags-sprite/flags32.css"
    />
    <script src="{{asset('js/getCountryName.js')}}"></script>
@endsection


<div class="profile-outside-container">
    <div class="profile-inside-container">
        <img class="profile-image" src="https://cdn.pixabay.com/photo/2017/02/25/22/04/user-icon-2098873_960_720.png">
        <div class="name-div">
            <label>
                <b>Firstname:</b> {{Auth::user()->first_name}}
            </label>
            <label>
                <b>Lastname:</b> {{Auth::user()->last_name}}
            </label>
        </div>

        <div class="birthdate-div">
            <label>
                <b>Birthdate:</b> {{Auth::user()->birthday}}
            </label>
        </div>

        <div class="gender-div">
            <label>
                <b>Gender:</b> {{Auth::user()->gender}}
            </label>
        </div>

        <div class="email-div">
            <label>
                <b>Email:</b> {{Auth::user()->email}}
            </label>
        </div>

        <div class="last-migrations-div">
            <label>
                Last Migrations
            </label>
            <table>
                <tr>
                    <th class="to-cell"> <div> From</div> </th>
                    <th class="reason-cell"> <div>  Reason </div> </th>
                    <th class="from-cell"> <div>  To </div> </th>
                </tr>

                @foreach($migrations as $migration)
                <tr>
                    <td class="from-cell">
                        <div class="f32">
                            <div class="flag {{strtolower($migration->departure_country)}}"></div>
                        </div>
                        <br>
                        City:{{$migration->departure_city}}
                    </td>
                    <td class="reason-cell">
                        <div class="username">
                            User: {{$migration->user->username}}
                        </div>
                        <div class="reason">
                            Reason: {{$migration->reason}}
                            @if ($migration->reason == 'Education')
                                <img class="reason-image" src="{{asset('img/reason/education.svg')}}" alt="Economics Reason photo">
                            @elseif ($migration->reason == 'Religion')
                                <img class="reason-image" src="{{asset('img/reason/religion.svg')}}" alt="Religion Reason photo">
                            @elseif ($migration->reason == 'Economics')
                                <img class="reason-image" src="{{asset('img/reason/money.svg')}}" alt="Economics Reason photo">
                            @elseif ($migration->reason == 'War')
                                <img class="reason-image" src="{{asset('img/reason/war.svg')}}" alt="War Reason photo">
                            @elseif ($migration->reason == 'Personal')
                                <img class="reason-image" src="{{asset('img/reason/personal.svg')}}" alt="Personal Reason photo">
                            @elseif ($migration->reason == 'Other')
                                <img class="reason-image" src="{{asset('img/reason/other.svg')}}" alt="Personal Reason photo">
                            @endif
                        </div>
                        <div class="number-adults-children-div">
                            <div class="number-adults-div">
                                Nr adults: {{$migration->adults}}
                            </div>
                            <div class="number-children-div">
                                Nr children: {{$migration->children}}
                            </div>
                        </div>
                        <div class="time-elapsed">
                            {{Carbon\Carbon::parse($migration->created_at)->diffForHumans()}}
                        </div>
                    </td>
                    <td class="to-cell">
                        <div class="f32">
                            <div class="flag {{strtolower($migration->arrival_country)}}"></div>
                        </div>
                        <br>
                        City:{{$migration->arrival_city}}
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
</div>
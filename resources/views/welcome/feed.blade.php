@extends(Auth::user() ? 'layouts.app' : 'layouts.welcome');

@section('assets')
    <link rel="stylesheet" type="text/css" href="{{asset('css/feed.css')}}">
    <link
            rel="stylesheet"
            type="text/css"
            href="//cloud.github.com/downloads/lafeber/world-flags-sprite/flags32.css"
    />
    <script src="{{asset('js/getCountryName.js')}}"></script>
@endsection

@section('content')
    <div class="body-container">
        <h1>
            Migration Feed
        </h1>
        <div class="submit-button-div" >
            <a href="{{route('feed.get')}}" title="Subscribe to Migration Feed" class="btn btn-warning btn-lg\" target="_blank">
                <div class="row">
                    <div class="col-md-12">
                        <i class="fa fa-2x fa-rss"></i>
                    </div>
                </div>
            </a>
        </div>

        <div class="table-div">
            <table>
                <tr>
                    <th class="from-cell"> <div> From</div> </th>
                    <th class="reason-cell"> <div>  Reason </div> </th>
                    <th class="to-cell"> <div>  To </div> </th>
                </tr>

                @foreach($migrations as $migration)
                    <tr>
                        <td class="from-cell">
                            <div class="f32">
                                <div class="flag {{strtolower($migration->departure_country)}}"></div>
                            </div>
                            Country:<script>
                                document.write(getCountryName('{{$migration->departure_country}}'));
                            </script> <br>
                            City:{{$migration->departure_city}}
                        </td>
                        <td class="reason-cell">
                            <div class="username">
                                User: {{\App\User::find($migration->user_id)->email}}
                            </div>
                            <div class="reason">
                                Reason: {{$migration->reason}}
                            </div>
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
                            <div class="number-adults-children-div">
                                <div class="number-adults-div">
                                    Adults: {{$migration->adults}}
                                </div>
                                <div class="number-children-div">
                                    Children: {{$migration->children}}
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
                            Country:<script>
                                document.write(getCountryName('{{$migration->arrival_country}}'));
                            </script> <br>
                            City:{{$migration->arrival_city}}
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>

        @include('pagination.better', ['paginator' => $migrations])
    </div>
@endsection

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <!--if had more time, would've downloaded the cdns and made html template-->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Laravel</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.22.2/dist/bootstrap-table.min.css">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    </head>
    <div id="menu-layout">
        <div class="title">
            <h1>SneakyHero</h1>
            <h3>Welcome!</h3>
            <h3>Avoid the boss!</h3>
        </div>
        <div class="buttonplaygame">
            <button onclick='javascript:playGame();' id="playButton">Play game</button>
            <button onclick='javascript:showLeaderboard();' id="leaderboardButton">Leaderboard</button>
        </div>
    </div>
    <canvas id="gameCanvas" width="800" height="400" display="none"></canvas>
    <div id="timer" display="none"></div>
    <div id="leaderboard" display='none'>
        <h1>Leaderboard</h1>
        <h2>Here you find the top 5 players with the highest time!</h2>
        <div class="table-responsive">
        <table id="exporttable" class="table table-striped table-hover" data-toggle="table" data-show-export="true" data-export-data-type="all" data-export-types="['excel','json', 'csv','doc']" data-show-columns="true" data-show-toggle="false" data-show-refresh="true" data-pagination="true" data-search="true" data-page-size=10 data-cookie="true" data-side-pagination="server">
            <thead>
            <th id='username' data-sortable="true" data-field="username"><h2>Username</h2></th>
            <th id='secondsplayed' data-sortable="true" data-field="highestScore"><h2>Highscore</h2></th>
                @foreach($players as $key)
            <tr>
                    <th scope="col" title="<?php echo $key->name ?>"><?php echo $key->name ?></th>
                    <th scope="col"  data-field="secondsplayed" title="<?php echo $key->highestscore ?>"><?php echo $key->highestscore ?></th>
                @endforeach
            </thead>
            <tbody class="sortable">
            </tbody>
        </table>
    </div>
        <button id="goBackButton" onclick="javascript:goBackMenu();">Go back</button>
    </div>
    <div id="modalStyle">
        <div id="myModal" class="modal fade" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Welcome to my game SneakyHero!</h5>
                    </div>
                    <div class="modal-body">
                        <p id="modalText">First you need to put your username in, so your username can be put on the leaderboard.</p>
                            <div class="form-group">
                            <form  id="formInput" action="{{   url('/')  }}" method="POST">
                           @csrf
                                <input type="text" class="form-control" placeholder="username" id="username" name="username">
                            </div>
                            <button type="button"  name="submit" data-dismiss="modal" id="submit" value="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.22.2/dist/bootstrap-table.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.22.2/dist/locale/bootstrap-table-zh-CN.min.js"></script>


   

<script src="{{ asset('js/script.js') }}"></script>

<script>
        $.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
    </script>
    </body>
</html>

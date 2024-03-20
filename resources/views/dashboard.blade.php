<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.22.2/dist/bootstrap-table.min.css">
</head>
<body>




<form method="POST" action="{{url('createPlayer')}}">
    @csrf
    <div class="mb-3">
        <label for="username" class="form-label">Player Username</label>
        <input type="text" class="form-control" id="username" name="username" aria-describedby="username">
    </div>
    <div class="mb-3">
        <label for="highscore" class="form-label">Highscore</label>
        <input type="text" class="form-control" id="highscore" name="highscore">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

  



<div class="container mt-3">
  <h2>Basic Table</h2>
  <p>The .table class adds basic styling (light padding and horizontal dividers) to a table:</p>            
  <table class="table">
    <thead>
      <tr>
        <th>id</th>
        <th>username</th>
        <th>score</th>
        <th>edit/delete</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($data as $key)
      <tr>
        <td><?php echo $key->player_id ?></td>
        <td><?php echo $key->name ?></td>
        <td><?php echo $key->highestscore?></td>
        <td><button><a href="{{url('/dashboard/edit/'.$key->player_id)}}">edit</a></button><button><a href="{{url('/dashboard/delete/'.$key->player_id)}}">delete</a></button></td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>



   
<script src="{{ asset('js/jquery.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.22.2/dist/bootstrap-table.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.22.2/dist/locale/bootstrap-table-zh-CN.min.js"></script>
</body>
</html>

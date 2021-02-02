 @extends('layouts.admin_main')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Check all  your page post on facebook</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href=""> ALL PAGE POST</a>
        
            </div>
        </div>
    </div>
   
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
   
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Post_id</th>
            <th>Message|link|photo|video</th>
            <th width="250px">Action</th>
        </tr>
     {{$i=0}}
             @foreach($items_name as $item => $id)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $id }}</td>
            <td>{{ $item }}</td>
            <td>
            
      
                    <a href="/deleteppost/{{$id}}" type="submit" class="btn btn-danger">Delete</a>
            </td>
        </tr>
        @endforeach
    </table>
  
  

 @endsection
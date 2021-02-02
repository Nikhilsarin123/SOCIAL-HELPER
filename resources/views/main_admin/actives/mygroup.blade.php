@extends('layouts.admin_main')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>CHECK ALL YOUR GROUPS</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href=""> ALL GROUPS</a>
        
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
            <th>group_id</th>
            <th>My all pages</th>
            <th width="250px">Action</th>
        </tr>
     {{$i=0}}
             @foreach($items_name as $id => $item)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $id }}</td>
            <td>{{ $item }}</td>
            <td>
        
            </td>
        </tr>
        @endforeach
    </table>
  
  

 @endsection
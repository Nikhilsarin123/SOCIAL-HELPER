@extends('layouts.admin_main')

@section('content')
<section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">SELECT PAGE YOU WANT TO SEE THE POST</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
               @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
              <form role="form" action="{{ route('pshow.store') }}" enctype="multipart/form-data" method="post">
                 @csrf
                 <div class="form-group @error('location') is-invalid @enderror">
                        <label>Select Group You Want To post</label>
                         <a href="#" class="btn btn-block btn-primary">
                         <i class="fab fa-facebook mr-2"></i> select The page of which you want to see the post
                            </a>
                        <select name="page_id" value="page_id" class="form-control">
                              <option value="">--- Select Group ---</option>
                            
                          @foreach($items_name as $id => $item)
                           <option value="{{$item}}" >{{$id}}</option>
                          @endforeach
        
                        @error('GroupName')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </select>
                      </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>

  @endsection
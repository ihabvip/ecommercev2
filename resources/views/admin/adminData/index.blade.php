@extends('admin.index')
@section('title','Admin Table')
@section('content')
<div class="box">
    <div class="box-header">
    <h3 class="box-title">{{$titleTable}}</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        {!! $dataTable->table([
    
            'class'=>'dataTable table table-striped table-hover table-bordered'
            ]) 
            
        !!}      
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->
  @push('js')
  {!! $dataTable->scripts() !!}    
  @endpush
@endsection
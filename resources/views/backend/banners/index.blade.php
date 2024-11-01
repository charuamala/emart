@extends('backend.layouts.master')

@section('content')
<div id="main-content">
    <div class="container-fluid">
        <div class="block-header">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <h2>
                        <a href="javascript:void(0);" class="btn btn-xs btn-link btn-toggle-fullwidth">
                            <i class="fa fa-arrow-left"></i>
                        </a> 
                        Banner
                        <a class="btn btn-sm btn-outline-secondary" href="{{route('banner.create')}}"><i class="icon-plus"></i> Create Banner</a>
                    </h2>
                    <ul class="breadcrumb float-left">
                        <li class="breadcrumb-item"><a href="{{route('admin')}}"><i class="icon-home"></i></a></li>
                        <li class="breadcrumb-item active">Banner</li>
                    </ul>
                    <p class="float-right">Total Banners: {{\App\Models\Banner::count()}}</p>
                </div>            
                <div class="col-lg-6 col-md-4 col-sm-12 text-right">
                    <!-- Your stats code here -->
                </div>
            </div>
        </div>
        
        <div class="row clearfix">
            <div class="col-lg-12">
                @include('backend.layouts.notification')
            </div>
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>Banner</strong> List</h2>
                    </div>
                    <div class="body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover js-basic-example dataTable">
                                <thead>
                                    <tr>
                                        <th>S No.</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Photo</th>
                                        <th>Condition</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>                            
                                <tbody>
                                    @if($banners->isEmpty())
                                        <tr>
                                            <td colspan="7" class="text-center">No banners found.</td>
                                        </tr>
                                    @else
                                        @foreach ($banners as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->title }}</td>
                                                <td>{!! html_entity_decode($item->description ) !!}</td>
                                                <td>
                                                    <img src="{{ asset('uploads/banners/'.$item->photo) }}" alt="banner img" style="max-height:90px; max-width:120px">
                                                </td>
                                                <td>
                                                    <span class="badge {{ $item->condition == 'banner' ? 'badge-success' : 'badge-primary' }}">
                                                        {{ $item->condition }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="toggle" value="{{ $item->id }}" data-toggle="switchbutton" {{ $item->status == 'active' ? 'checked' : '' }} data-onlabel="Active" data-offlabel="Inactive" data-size="sm" data-onstyle="success" data-offstyle="danger">

                                                    {{-- <input type="checkbox" name='toggle' value='{{ $item->id }}' data-toggle="switchbutton" {{ $item->status == 'active' ? 'checked' : '' }} data-onlabel="Active" data-offlabel="Inactive" data-size="sm" data-onstyle="success" data-offstyle="danger"> --}}
                                                </td>
                                                <td>
                                                    <a href="{{ route('banner.edit', $item->id) }}" class='btn btn-sm btn-outline-warning' title='edit'>
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('banner.destroy', $item->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class='dltBtn btn btn-sm btn-outline-danger' title='delete' data-id="{{$item->id}}">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>                   
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
  $('input[name=toggle]').change(function() {
    var mode = $(this).is(':checked'); // This will be true or false
    var id = $(this).val();

    $.ajax({
        url: "{{ route('banner.status') }}",
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            mode: mode, // Ensure this is a boolean
            id: id,
        },
        success: function(response) {
            if(response.status){
                alert(response.msg);
            } else{
                alert('Please try again');
            }// Log success message
        },
        error: function(xhr) {
            console.log(xhr.responseJSON); // Log the error response for debugging
            alert('Error updating status: ' + (xhr.responseJSON.message || 'An error occurred.'));
        }
    });
});

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$('.dltBtn').click(function(e){
    var form = $(this).closest('form');
    var dataID = $(this).data('id');
    e.preventDefault();
    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this image!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                form.submit();
                swal("Poof! Your Image file has been deleted!", {
                icon: "success",
                });
            } else {
                swal("Your Image file is safe!");
            }
        });
});

</script>
@endsection

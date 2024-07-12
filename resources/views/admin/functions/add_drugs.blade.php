@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row mt-5">
            <div class="col-md-12">
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">
                            <i class="fas fa-file-excel"></i> Import Excel Data into Database
                        </h4>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('admin.upload.drugs') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="drugs" class="form-label">Choose Excel File:</label>
                                <div class="input-group">
                                    <input type="file" name="drugs" class="form-control" id="drugs" required>
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-upload"></i> Import</button>
                                </div>
                            </div>

                        </form>

                        <hr>

                        <div class="mb-3">
                            <input type="text" id="search" class="form-control" placeholder="Search...">
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name (English)</th>
                                        <th>Name (Arabic)</th>
                                        <th>Price</th>
                                        <th>Image</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($drugs as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->name_en }}</td>
                                            <td>{{ $item->name_ar }}</td>
                                            <td>{{ $item->price }}</td>
                                            <td>
                                                <img src="{{ $item->image_url }}" alt="Image" class="img-thumbnail" style="max-width: 100px;">
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No drugs found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            {{ $drugs->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#search').on('input', function() {
            var searchText = $(this).val().toLowerCase();
            $('tbody tr').each(function() {
                var drugNameEn = $(this).find('td:eq(1)').text().toLowerCase();
                var drugNameAr = $(this).find('td:eq(2)').text().toLowerCase();
                if (drugNameEn.includes(searchText) || drugNameAr.includes(searchText)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    });
</script>
@endsection

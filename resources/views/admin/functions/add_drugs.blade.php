@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 mt-5">
                @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
                @endif


                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Import Excel Data into Database</h4>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('admin.upload.drugs') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="input-group mb-3">
                                <input type="file" name="drugs" class="form-control" required />
                                <button type="submit" class="btn btn-primary">Import</button>
                            </div>

                        </form>

                        <div class="mb-3">
                            <input type="text" id="search" class="form-control" placeholder="Search...">
                        </div>
                        <hr>
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name (English)</th>
                                        <th>Name (Arabic)</th>
                                        <th>New Price</th>
                                        <th>Old Price</th>
                                        <th>Active Ingredient</th>
                                        <th>Company</th>
                                        <th>Usage</th>
                                        <th>Units</th>
                                        <th>Dosage Form</th>
                                        <th>Parcode</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($drugs as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->name_en }}</td>
                                            <td>{{ $item->name_ar }}</td>
                                            <td>{{ $item->new_price }}</td>
                                            <td>{{ $item->old_price }}</td>
                                            <td>{{ $item->active_ingredient }}</td>
                                            <td>{{ $item->company }}</td>
                                            <td>{{ $item->usage }}</td>
                                            <td>{{ $item->units }}</td>
                                            <td>{{ $item->dosage_form }}</td>
                                            <td>{{ $item->parcode }}</td>
                                        </tr>
                                    @endforeach
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
</script>
@endsection

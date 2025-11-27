@extends('backend.layouts.app')

@section('content')
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Sliders List</h2>
            {{-- <p>Lorem ipsum dolor sit amet.</p> --}}
        </div>
        <div>
            {{-- <a href="#" class="btn btn-light rounded font-md">Export</a> --}}
            {{-- <a href="#" class="btn btn-light rounded  font-md">Import</a> --}}
            <a href="{{ route('admin.sliders.create') }}" class="btn btn-primary btn-sm rounded">Add New Slider</a>
        </div>
    </div>
    <div class="col-12">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
    </div>
    <div class="card mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Slider Image</th>
                            <th scope="col">slider Heading</th>
                            <th scope="col">Slider Sub Heading</th>
                            <th scope="col">Slider Paragraph</th>
                            <th scope="col">Slider Button</th>
                            <th scope="col" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sliders as $slider)
                            <tr>
                                <td><img src="{{ asset($slider->image) }}" alt="{{ $slider->heading }}" width="10%">
                                </td>
                                <td>{{ $slider->heading }}</td>
                                <td>{{ $slider->order }}</td>
                                <td>{{ $slider->is_active ? 'Active' : 'Inactive' }}</td>
                                <td>{{ $slider->button_name }}</td>
                                <td>
                                    <a href="{{ route('admin.sliders.edit', $slider->id) }}"
                                        class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('admin.sliders.destroy', $slider->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div> <!-- card end// -->
    <div class="pagination-area mt-30 mb-50">
    </div>
@endsection

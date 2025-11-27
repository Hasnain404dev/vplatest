@extends('backend.layouts.app')
@section('content')
    <div class="row">
        <div class="col-12">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
        </div>
        <div class="col-12">
            <div class="content-header d-flex justify-content-between align-items-center">
                <h2 class="content-title">Edit Slider</h2>
                <button type="submit" form="sliderForm" class="btn btn-md rounded font-sm hover-up">Update</button>
            </div>
        </div>
        <div class="col-12">
            <form id="sliderForm" action="{{ route('admin.sliders.update', $slider->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="image" class="form-label">Slider Image</label>
                                    <div class="mb-2">
                                        <img src="{{ asset($slider->image) }}" alt="Current Slider Image" class="img-thumbnail" style="max-height: 150px;">
                                    </div>
                                    <input type="file" class="form-control" id="image" name="image">
                                    @error('image')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Leave blank to keep current image</small>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="heading" class="form-label">Heading</label>
                                    <input type="text" class="form-control" id="heading" name="heading"
                                           value="{{ old('heading', $slider->heading) }}">
                                    @error('heading')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="sub_heading" class="form-label">Sub Heading</label>
                                    <input type="text" class="form-control" id="sub_heading" name="sub_heading"
                                           value="{{ old('sub_heading', $slider->sub_heading) }}">
                                    @error('sub_heading')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="paragraph" class="form-label">Paragraph</label>
                                    <textarea class="form-control" id="paragraph" name="paragraph" rows="3">{{ old('paragraph', $slider->paragraph) }}</textarea>
                                    @error('paragraph')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="button_name" class="form-label">Button Name</label>
                                    <input type="text" class="form-control" id="button_name" name="button_name"
                                           value="{{ old('button_name', $slider->button_name) }}">
                                    @error('button_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="button_link" class="form-label">Button Link</label>
                                    <input type="url" class="form-control" id="button_link" name="button_link"
                                           value="{{ old('button_link', $slider->button_link) }}">
                                    @error('button_link')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="order" class="form-label">Order</label>
                                    <input type="number" class="form-control" id="order" name="order"
                                           value="{{ old('order', $slider->order) }}">
                                    @error('order')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active"
                                               value="1" {{ old('is_active', $slider->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">Active</label>
                                    </div>
                                    @error('is_active')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-3">
                    <a href="{{ route('admin.sliders') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Slider</button>
                </div>
            </form>
        </div>
    </div>
@endsection

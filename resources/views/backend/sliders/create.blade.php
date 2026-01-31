@extends('backend.layouts.app')
@section('content')
    <div class="row">
        <div class="col-12">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        <div class="col-12">
            <div class="content-header d-flex justify-content-between align-items-center">
                <h2 class="content-title">Add New Slider</h2>
                <button type="submit" form="sliderForm" class="btn btn-md rounded font-sm hover-up">Publish</button>
            </div>
        </div>
        <div class="col-12">
            <form id="sliderForm" action="{{ route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="image" class="form-label required">Slider Image*  </label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" required>
                                    @error('image')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Recommended size: 1200x600px (max 2MB)</small>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="heading" class="form-label">Heading</label>
                                    <input type="text" class="form-control" id="heading" name="heading" value="{{ old('heading') }}">
                                    @error('heading')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="sub_heading" class="form-label">Sub Heading</label>
                                    <input type="text" class="form-control" id="sub_heading" name="sub_heading" value="{{ old('sub_heading') }}">
                                    @error('sub_heading')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="paragraph" class="form-label">Paragraph</label>
                                    <textarea class="form-control" id="paragraph" name="paragraph" rows="3">{{ old('paragraph') }}</textarea>
                                    @error('paragraph')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Heading color</label>
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="color" class="form-control form-control-color" id="heading_color_picker" value="#ffffff" style="width:3rem;height:2.25rem;">
                                        <input type="text" class="form-control" id="heading_color" name="heading_color" value="{{ old('heading_color') }}" placeholder="#ffffff">
                                    </div>
                                    @error('heading_color')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Sub heading color</label>
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="color" class="form-control form-control-color" id="sub_heading_color_picker" value="#ffffff" style="width:3rem;height:2.25rem;">
                                        <input type="text" class="form-control" id="sub_heading_color" name="sub_heading_color" value="{{ old('sub_heading_color') }}" placeholder="#ffffff">
                                    </div>
                                    @error('sub_heading_color')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Paragraph text color</label>
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="color" class="form-control form-control-color" id="paragraph_color_picker" value="#ffffff" style="width:3rem;height:2.25rem;">
                                        <input type="text" class="form-control" id="paragraph_color" name="paragraph_color" value="{{ old('paragraph_color') }}" placeholder="#ffffff">
                                    </div>
                                    @error('paragraph_color')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="button_name" class="form-label">Button Name</label>
                                    <input type="text" class="form-control" id="button_name" name="button_name" value="{{ old('button_name') }}">
                                    @error('button_name')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="button_link" class="form-label">Button Link</label>
                                    <input type="url" class="form-control" id="button_link" name="button_link" value="{{ old('button_link') }}">
                                    @error('button_link')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="background_opacity" class="form-label">Background overlay opacity</label>
                                    <input type="range" class="form-range" id="background_opacity" name="background_opacity" min="0" max="100" value="{{ old('background_opacity', 40) }}">
                                    <small class="text-muted"><span id="background_opacity_val">40</span>% (darker = more readable text)</small>
                                    @error('background_opacity')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="text_color" class="form-label">Text color</label>
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="color" class="form-control form-control-color" id="text_color_picker" value="#ffffff" style="width:3rem;height:2.25rem;">
                                        <input type="text" class="form-control" id="text_color" name="text_color" value="{{ old('text_color', '#ffffff') }}" placeholder="#ffffff">
                                    </div>
                                    @error('text_color')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Button background color</label>
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="color" class="form-control form-control-color" id="button_bg_color_picker" value="#0d6efd" style="width:3rem;height:2.25rem;">
                                        <input type="text" class="form-control" id="button_bg_color" name="button_bg_color" value="{{ old('button_bg_color', '#0d6efd') }}" placeholder="#0d6efd">
                                    </div>
                                    @error('button_bg_color')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Legacy field still supported: Button color</small>
                                    <div class="d-flex align-items-center gap-2 mt-1">
                                        <input type="color" class="form-control form-control-color" id="button_color_picker" value="#0d6efd" style="width:3rem;height:2.25rem;">
                                        <input type="text" class="form-control" id="button_color" name="button_color" value="{{ old('button_color') }}" placeholder="#0d6efd">
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label class="form-label">Button text color</label>
                                    <div class="d-flex align-items-center gap-2">
                                        <input type="color" class="form-control form-control-color" id="button_text_color_picker" value="#ffffff" style="width:3rem;height:2.25rem;">
                                        <input type="text" class="form-control" id="button_text_color" name="button_text_color" value="{{ old('button_text_color', '#ffffff') }}" placeholder="#ffffff">
                                    </div>
                                    @error('button_text_color')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="order" class="form-label">Order</label>
                                    <input type="number" class="form-control" id="order" name="order" value="{{ old('order', 0) }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">Active</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-3">
                    <a href="{{ route('admin.sliders') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Slider</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.getElementById('background_opacity').addEventListener('input', function() {
            document.getElementById('background_opacity_val').textContent = this.value;
        });
        // Per-element color pickers sync
        function bindColorSync(pickerId, textId){
            var p = document.getElementById(pickerId);
            var t = document.getElementById(textId);
            if(!p || !t) return;
            p.addEventListener('input', function(){ t.value = this.value; });
            t.addEventListener('input', function(){ if(/^#[0-9A-Fa-f]{6}$/.test(this.value)) p.value = this.value; });
        }
        document.getElementById('text_color_picker').addEventListener('input', function() {
            document.getElementById('text_color').value = this.value;
        });
        document.getElementById('text_color').addEventListener('input', function() {
            if (/^#[0-9A-Fa-f]{6}$/.test(this.value)) document.getElementById('text_color_picker').value = this.value;
        });
        bindColorSync('button_color_picker','button_color');
        bindColorSync('button_bg_color_picker','button_bg_color');
        bindColorSync('button_text_color_picker','button_text_color');
        bindColorSync('heading_color_picker','heading_color');
        bindColorSync('sub_heading_color_picker','sub_heading_color');
        bindColorSync('paragraph_color_picker','paragraph_color');
    </script>
@endsection

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
                <h2 class="content-title">Add New Blog</h2>
                <button type="submit" form="blogForm" class="btn btn-md rounded font-sm hover-up">Publish</button>
            </div>
        </div>
        <div class="col-12">
            <form id="blogForm" action="{{ route('admin.blog.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-4">
                            <label for="title" class="form-label">Blog Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                                name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="slug" class="form-label">URL Slug (leave blank to auto-generate)</label>
                            <input type="text" class="form-control" id="slug" name="slug"
                                value="{{ old('slug', $blog->slug ?? '') }}">
                        </div>
                        <div class="mb-4">
                            <label for="description" class="form-label">Short Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                rows="3" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="content" class="form-label">Content</label>
                            <textarea class="form-control @error('content') is-invalid @enderror" id="editor" name="content"
                                style="display:none;">{{ old('content') }}</textarea>
                            <div id="editor-container" style="min-height: 400px; border: 1px solid #ddd; padding: 10px;">
                            </div>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Featured Image</h5>
                                <div class="mb-3">
                                    <input type="file" class="form-control @error('image') is-invalid @enderror"
                                        id="image" name="image" required>
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="image-preview mt-2">
                                    <img id="imagePreview" src="#" alt="Preview"
                                        style="max-width: 100%; display: none;">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Include CKEditor 5 with essential features -->
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/decoupled-document/ckeditor.js"></script>
    <style>
        .ck.ck-editor__editable_inline {
            min-height: 400px;
            padding: 1.5em;
            border: 1px solid var(--ck-color-base-border);
        }

        .ck.ck-toolbar {
            border: 1px solid var(--ck-color-base-border) !important;
        }
    </style>
    <script>
        // Image preview
        document.getElementById('image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('imagePreview');
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        });

        // Initialize CKEditor with essential features
        DecoupledEditor
            .create(document.getElementById('editor-container'), {
                toolbar: [
                    'heading', '|',
                    'bold', 'italic', 'underline', 'strikethrough', '|',
                    'bulletedList', 'numberedList', '|',
                    'alignment', '|',
                    'link', 'blockQuote', 'insertTable', 'mediaEmbed', '|',
                    'undo', 'redo'
                ],
                heading: {
                    options: [{
                            model: 'paragraph',
                            title: 'Paragraph',
                            class: 'ck-heading_paragraph'
                        },
                        {
                            model: 'heading1',
                            view: 'h1',
                            title: 'Heading 1',
                            class: 'ck-heading_heading1'
                        },
                        {
                            model: 'heading2',
                            view: 'h2',
                            title: 'Heading 2',
                            class: 'ck-heading_heading2'
                        },
                        {
                            model: 'heading3',
                            view: 'h3',
                            title: 'Heading 3',
                            class: 'ck-heading_heading3'
                        },
                        {
                            model: 'heading4',
                            view: 'h4',
                            title: 'Heading 4',
                            class: 'ck-heading_heading4'
                        },
                        {
                            model: 'heading5',
                            view: 'h5',
                            title: 'Heading 5',
                            class: 'ck-heading_heading5'
                        },
                        {
                            model: 'heading6',
                            view: 'h6',
                            title: 'Heading 6',
                            class: 'ck-heading_heading6'
                        }
                    ]
                }
            })
            .then(editor => {
                const toolbarContainer = document.createElement('div');
                toolbarContainer.classList.add('document-editor__toolbar');
                document.getElementById('editor-container').parentElement.insertBefore(toolbarContainer, document
                    .getElementById('editor-container'));
                toolbarContainer.appendChild(editor.ui.view.toolbar.element);

                // Update the hidden textarea with the editor content before form submission
                document.getElementById('blogForm').addEventListener('submit', function() {
                    document.getElementById('editor').value = editor.getData();
                });

                // Set initial content if there's any
                const initialContent = document.getElementById('editor').value;
                if (initialContent) {
                    editor.setData(initialContent);
                }
            })
            .catch(error => {
                console.error(error);
            });
    </script>

    <script>
        document.getElementById('title').addEventListener('keyup', function() {
            if (!document.getElementById('slug').value) {
                document.getElementById('slug').value = this.value.toLowerCase()
                    .replace(/[^\w ]+/g, '')
                    .replace(/ +/g, '-');
            }
        });
    </script>
@endsection

<x-admin-layout>
    <x-slot name="header">
        {{ __('Create Category') }}
    </x-slot>
    <section class="content">
        <div class="container-fluid">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @elseif (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            <form action={{ route('category.update', $category->id) }} method="POST">
                @method('PUT')
                @csrf
                <div class="card">
                    <div class="card-body">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        placeholder="Name" value="{{ $category->name }}" required>
                                </div>
                                @error('name')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="slug">Slug</label>
                                    <input type="text" name="slug" id="slug" class="form-control"
                                        placeholder="Slug" required readonly value="{{ $category->slug }}">
                                </div>

                                @error('slug')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror

                            </div>
                            <div class="col-md-6">
                                <label for="image">Image</label>
                                <div class="mb-3">
                                    <div id="image" class="dropzone dz-clickable">
                                        <div class="dz-message needsclick">
                                            <br>Drop files here or click to upload.<br><br>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" value="" name="image_id" id="image_id">
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control" placeholder="Status">
                                        <option {{ $category->status == 1 ? 'selected' : '' }} value="1">Active
                                        </option>
                                        <option {{ $category->status == 0 ? 'selected' : '' }} value="0">Draft
                                        </option>
                                    </select>
                                </div>
                            </div>
                            @if (!empty($category->image))
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="status">Image</label>
                                        <img src="{{ asset('/uploads/category/thumb/' . $category->image) }}"
                                            alt="" height="100px" width="100px">

                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('categories.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
        </div>
    </section>


    <script>
        setTimeout(function() {
            $('.alert.alert-success').fadeOut('slow');
        }, 1000);
        setTimeout(function() {
            $('.alert.alert-danger').fadeOut('slow');
        }, 1000);
        document.getElementById('name').addEventListener('input', function() {
            const nameInput = this.value.trim();
            const slugInput = document.getElementById('slug');
            const slug = nameInput.replace(/\s+/g, '-').replace(/[^a-zA-Z0-9\-]/g, '').toLowerCase();
            slugInput.value = slug;
        });
    </script>
    <script type="text/javascript">
        Dropzone.autoDiscover = false;
        const dropzone = $("#image").dropzone({
            init: function() {
                this.on('addedfile', function(file) {
                    if (this.files.length > 1) {
                        this.removeFile(this.files[0]);
                    }
                });
            },
            url: "{{ route('temp-images.create') }}",
            maxFiles: 1,
            paramName: 'image',
            addRemoveLinks: true,
            acceptedFiles: "image/jpeg,image/png,image/gif",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(file, response) {
                $("#image_id").val(response.image_id);
                console.log(response)
            }
        });
    </script>

</x-admin-layout>

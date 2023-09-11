<x-admin-layout>
    <x-slot name="header">
        {{ __('Edit Sub category') }}
    </x-slot>
    <section class="content">

        <div class="container-fluid">
            <form action="{{ route('sub.category.update', $data->id) }}" method="POST">
                @method('PUT')
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="name">Category</label>
                                    <select name="category_id" id="category" class="form-control">
                                        <option value="0">Select Category</option>
                                        @if (!empty($categories))
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ $category->id == $data->category_id ? 'selected' : '' }}>
                                                    {{ $category->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @error('category_id')
                                        <div class="text-danger">Select a category</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        placeholder="Name" value="{{ $data->name }}">
                                </div>
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email">Slug</label>
                                    <input type="text" name="slug" id="sub_slug" class="form-control"
                                        placeholder="Slug" required readonly value="{{ $data->slug }}">
                                </div>
                                @error('slug')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control" placeholder="Status">
                                        <option {{ $data->status == 1 ? 'selected' : '' }} value="1">Active
                                        </option>
                                        <option {{ $data->status == 0 ? 'selected' : '' }} value="0">Draft
                                        </option>
                                    </select>
                                </div>
                                @error('status')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button class="btn btn-primary">Update</button>
                    <a href="{{ route('sub.category.index') }}" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
        </div>
        <!-- /.card -->
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
            const slugInput = document.getElementById('sub_slug');
            const slug = nameInput.replace(/\s+/g, '-').replace(/[^a-zA-Z0-9\-]/g, '').toLowerCase();
            slugInput.value = slug;
        });
    </script>
</x-admin-layout>

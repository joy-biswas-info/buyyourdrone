<x-admin-layout>
    <x-slot name="header">
        {{ __('Create SubCategory') }}
    </x-slot>
    <section class="content">

        <div class="container-fluid">
            <form action="{{ route('sub.category.store') }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="name">Category</label>
                                    <select name="category_id" id="category" class="form-control">
                                        <option value="0">Select Category</option>
                                        @if (!empty($data))
                                            @foreach ($data as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
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
                                        placeholder="Name">
                                </div>
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email">Slug</label>
                                    <input type="text" name="slug" id="slug" class="form-control"
                                        placeholder="Slug" readonly>
                                </div>
                                @error('slug')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control" placeholder="Status">
                                        <option value="1">Active</option>
                                        <option value="0">Draft</option>
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
                    <button class="btn btn-primary">Create</button>
                    <a href="subcategory.html" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
            </form>
        </div>
        <!-- /.card -->
    </section>
    <script>
        setTimeout(function() {
            $('.alert.alert-success').fadeOut('slow');
        }, 7000);
        document.getElementById('name').addEventListener('input', function() {
            const nameInput = this.value.trim();
            const slugInput = document.getElementById('slug');
            const slug = nameInput.replace(/\s+/g, '-').replace(/[^a-zA-Z0-9\-]/g, '').toLowerCase();
            slugInput.value = slug;
        });
    </script>
</x-admin-layout>

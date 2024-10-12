@extends('admin.layout.main')

@section('admin-page-title', ucfirst($mode ?? 'create') . ' User')

@section('admin-main-section')

    <!-- PAGE-HEADER -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="page-title">{{ ucfirst($mode ?? 'create') }} User</h1>
        </div>
    </div>
    <!-- PAGE-HEADER END -->

    <!-- Row -->
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ ucfirst($mode ?? 'create') }} User</h3>
                </div>
                <div class="card-body">
                    @if ($mode == 'edit' || $mode == 'create')
                        <form method="POST"
                            action="{{ $mode == 'create' ? route('admin.users.store') : route('admin.users.update', $user->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @if ($mode == 'edit')
                                @method('PUT')
                            @endif
                    @endif

                    <div class="form-row">
                        <div class="col-xl-4 mb-3">
                            <label class="form-label mt-0" for="name">Full Name</label>
                            @if ($mode == 'edit' || $mode == 'create')
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name', $mode == 'edit' ? $user->name : '') }}">
                            @else
                                <p class="form-control">{{ $user->name }}</p>
                            @endif
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-xl-4 mb-3">
                            <label class="form-label mt-0" for="email">Email</label>
                            @if ($mode == 'edit' || $mode == 'create')
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ old('email', $mode == 'edit' ? $user->email : '') }}">
                            @else
                                <p class="form-control">{{ $user->email }}</p>
                            @endif
                            @error('email')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-xl-4 mb-3">
                            <label class="form-label mt-0" for="role">User Role</label>
                            @if ($mode == 'edit' || $mode == 'create')
                                <select class="form-select form-control" id="role" name="role">
                                    <option value="1"
                                        {{ old('role', $mode == 'edit' ? $user->user_role : '') == 1 ? 'selected' : '' }}>
                                        Administrator</option>
                                    <option value="2"
                                        {{ old('role', $mode == 'edit' ? $user->user_role : '') == 2 ? 'selected' : '' }}>
                                        Editor</option>
                                    <option value="3"
                                        {{ old('role', $mode == 'edit' ? $user->user_role : '') == 3 ? 'selected' : '' }}>
                                        Viewer</option>
                                </select>
                            @else
                                <p class="form-control">
                                    @switch($user->user_role)
                                        @case(1)
                                            Administrator
                                        @break

                                        @case(2)
                                            Editor
                                        @break

                                        @case(3)
                                            Viewer
                                        @break
                                    @endswitch
                                </p>
                            @endif
                            @error('role')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        @if ($mode == 'edit' || $mode == 'create')
                            <x-inputs.input-field label="Avatar" name="avatar" type="file" />
                        @else
                            <p>{{ $user->avatar }}</p>
                        @endif

                        @if ($mode == 'edit' || $mode == 'create')
                            <div class="col-xl-4 mb-3">
                                <label class="form-label mt-0" for="password">New Password</label>
                                <input type="password" class="form-control" id="password" name="password">
                                @if ($mode == 'edit')
                                    <small class="text-muted">Leave blank to keep the current password.</small>
                                @endif
                                @error('password')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-xl-4 mb-3">
                                <label class="form-label mt-0" for="password_confirmation">Confirm Password</label>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation">
                                @error('password_confirmation')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif
                    </div>

                    @if ($mode == 'edit' || $mode == 'create')
                        <center><button class="btn btn-primary" type="submit">{{ ucfirst($mode) }} User</button></center>
                    @endif

                    @if ($mode == 'edit' || $mode == 'create')
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- End Row -->

@endsection

@section('custom-script')
    <script src="{{ asset('assets/plugins/input-mask/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('assets/js/form-validation.js') }}"></script>
@endsection

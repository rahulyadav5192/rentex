@extends('layouts.app')

@section('page-title')
    {{ __('Blog Management') }}
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item" aria-current="page">{{ __('Blog Management') }}</li>
@endsection

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="card table-card">
            <div class="card-header">
                <div class="row align-items-center g-2">
                    <div class="col">
                        <h5>{{ __('Blog List') }}</h5>
                    </div>
                    <div class="col-auto">
                        <a href="#" class="btn btn-secondary customModal" data-size="xl"
                            data-url="{{ route('blog.create') }}" data-title="{{ __('Create Blog') }}">
                            <i class="ti ti-circle-plus align-text-bottom"></i> {{ __('Create Blog') }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="dt-responsive table-responsive">
                    <table class="table table-hover" id="pc-dt-simple">
                        <thead>
                            <tr>
                                <th>{{ __('Thumbnail') }}</th>
                                <th>{{ __('Title') }}</th>
                                <th>{{ __('Category') }}</th>
                                <th>{{ __('Author') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Views') }}</th>
                                <th>{{ __('Created At') }}</th>
                                <th class="text-end">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($blogs as $blog)
                                <tr>
                                    <td>
                                        @if(!empty($blog->image))
                                            @php
                                                $imageUrl = fetch_file($blog->image, 'upload/blog/image/');
                                            @endphp
                                            @if(!empty($imageUrl))
                                                <img src="{{ $imageUrl }}" alt="{{ $blog->title }}" 
                                                     style="width: 80px; height: 60px; object-fit: cover; border-radius: 4px;">
                                            @else
                                                <div style="width: 80px; height: 60px; background: #f0f0f0; border-radius: 4px; display: flex; align-items: center; justify-content: center;">
                                                    <i class="ti ti-image" style="font-size: 24px; color: #999;"></i>
                                                </div>
                                            @endif
                                        @else
                                            <div style="width: 80px; height: 60px; background: #f0f0f0; border-radius: 4px; display: flex; align-items: center; justify-content: center;">
                                                <i class="ti ti-image" style="font-size: 24px; color: #999;"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $blog->title }}</strong>
                                        @if($blog->description)
                                            <br><small class="text-muted">{{ Str::limit($blog->description, 50) }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($blog->category)
                                            <span class="badge bg-info">{{ $blog->category }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $blog->author ?? '-' }}</td>
                                    <td>
                                        @if($blog->enabled)
                                            <span class="badge bg-success">{{ __('Published') }}</span>
                                        @else
                                            <span class="badge bg-secondary">{{ __('Draft') }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $blog->views ?? 0 }}</td>
                                    <td>{{ dateFormat($blog->created_at) }}</td>
                                    <td class="text-end">
                                        <div class="action-btn bg-info ms-2">
                                            <a href="#" class="mx-3 btn btn-sm align-items-center customModal" 
                                               data-size="xl" data-url="{{ route('blog.edit', $blog->id) }}" 
                                               data-title="{{ __('Edit Blog') }}">
                                                <i class="ti ti-pencil text-white"></i>
                                            </a>
                                        </div>
                                        <div class="action-btn bg-danger ms-2">
                                            <a href="#" class="mx-3 btn btn-sm align-items-center bs-pass-para" 
                                               data-confirm="{{ __('Are You Sure?') }}" 
                                               data-text="{{ __('This action can not be undone. Do you want to continue?') }}" 
                                               data-confirm-yes="delete-form-{{ $blog->id }}">
                                                <i class="ti ti-trash text-white"></i>
                                            </a>
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['blog.destroy', $blog->id], 'id' => 'delete-form-' . $blog->id]) !!}
                                            {!! Form::close() !!}
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">{{ __('No blogs found.') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center mt-3">
                    {{ $blogs->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@extends('layouts.admin')

@section('title')
    Créer une page statique
@endsection

@section('content')

<form action="{{ route('admin.static-pages.store') }}" method="post">
    <div class="card p-4 mb-4">
        @csrf

        <div class="mb-3">
            <label for="name" class="block text-xs mb-1">Nom<span class="text-red-500">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control w-full">
            @if ($errors->has('name'))
                <div class="text-red-500 mb-3 text-xs font-bold">
                    {{ $errors->first('name') }}
                </div>
            @endif
        </div>

        <div class="mb-3">
            <label for="slug" class="block text-xs mb-1">Slug<span class="text-red-500">*</span></label>
            <input type="text" name="slug" id="slug" value="{{ old('slug') }}" class="form-control w-full">
            @if ($errors->has('slug'))
                <div class="text-red-500 mb-3 text-xs font-bold">
                    {{ $errors->first('slug') }}
                </div>
            @endif
        </div>

        <div class="mb-3">
            <label for="content" class="block text-xs mb-1">Contenu (markdown)<span class="text-red-500">*</span></label>
            <textarea name="content" id="content" class="form-control w-full h-64">{{ old('content') }}</textarea>
            @if ($errors->has('content'))
                <div class="text-red-500 mb-3 text-xs font-bold">
                    {{ $errors->first('content') }}
                </div>
            @endif
        </div>

        <div class="mb-3">
            <label for="type" class="block text-xs mb-1">Type (1: contenu, 2: lien, 3: lien nouvel onglet)<span class="text-red-500">*</span></label>
            <input name="type" id="type" class="form-control w-full" value="{{ old('type') }}">
            @if ($errors->has('type'))
                <div class="text-red-500 mb-3 text-xs font-bold">
                    {{ $errors->first('type') }}
                </div>
            @endif
        </div>

        <div class="mb-3">
            <label for="position" class="block text-xs mb-1">Position (0: caché, 1: header, 2: sidebar, 3: footer)<span class="text-red-500">*</span></label>
            <input name="position" id="position" class="form-control w-full" value="{{ old('position') }}">
            @if ($errors->has('position'))
                <div class="text-red-500 mb-3 text-xs font-bold">
                    {{ $errors->first('position') }}
                </div>
            @endif
        </div>
    </div>
    <div class="text-right">
        <button class="btn btn-primary">
            Valider
        </button>
    </div>
</form>

@endsection

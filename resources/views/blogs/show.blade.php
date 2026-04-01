@extends('layouts.app')

@section('title', $blog->title_fr)

@section('content')

    <a href="{{ route('blogs.index') }}" class="btn edit">← Retour</a>

    <h2 class="title">{{ $blog->title_fr }}</h2>
    <h4 style="color:#888;">{{ $blog->title_en }}</h4>

    @if($blog->image)
        <img src="{{ asset('storage/' . $blog->image) }}" style="width:300px;border-radius:10px;margin:15px 0;">
    @endif

    <table>
        <tr>
            <th>Catégorie</th>
            <td>{{ $blog->category?->name_fr ?? '-' }}</td>
        </tr>
        <tr>
            <th>Auteur</th>
            <td>{{ $blog->auteur?->name ?? '-' }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>{{ $blog->status }}</td>
        </tr>
        <tr>
            <th>Publié le</th>
            <td>{{ $blog->published_at ?? '-' }}</td>
        </tr>
        <tr>
            <th>Slug FR</th>
            <td>{{ $blog->slug_fr }}</td>
        </tr>
        <tr>
            <th>Slug EN</th>
            <td>{{ $blog->slug_en }}</td>
        </tr>
    </table>

    @if($blog->content_fr)
        <div style="margin-top:20px;">
            <h3>Contenu</h3>
            <p>{{ $blog->content_fr }}</p>
        </div>
    @endif

    @if($blog->seo_title_fr)
        <div style="margin-top:20px;padding:10px;background:#f5f5f5;border-radius:8px;">
            <h3>SEO</h3>
            <p><strong>SEO Title:</strong> {{ $blog->seo_title_fr }}</p>
            <p><strong>Meta Desc:</strong> {{ $blog->meta_desc_fr }}</p>
        </div>
    @endif

@endsection
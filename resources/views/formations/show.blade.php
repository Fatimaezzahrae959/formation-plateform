@extends('layouts.app')

@section('title', $formation->title_fr)

@section('content')

    <a href="{{ route('formations.index') }}" class="btn edit">← Retour</a>

    <h2 class="title">{{ $formation->title_fr }}</h2>
    <h4 style="color:#888;">{{ $formation->title_en }}</h4>

    @if($formation->image)
        <img src="{{ asset('storage/' . $formation->image) }}" style="width:300px;border-radius:10px;margin:15px 0;">
    @endif

    <table>
        <tr>
            <th>Catégorie</th>
            <td>{{ $formation->category?->name_fr ?? '-' }}</td>
        </tr>
        <tr>
            <th>Prix</th>
            <td>{{ $formation->price }} MAD</td>
        </tr>
        <tr>
            <th>Durée</th>
            <td>{{ $formation->duration ?? '-' }}</td>
        </tr>
        <tr>
            <th>Niveau</th>
            <td>{{ $formation->level ?? '-' }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>{{ $formation->status }}</td>
        </tr>
        <tr>
            <th>Slug FR</th>
            <td>{{ $formation->slug_fr }}</td>
        </tr>
        <tr>
            <th>Slug EN</th>
            <td>{{ $formation->slug_en }}</td>
        </tr>
    </table>

    @if($formation->short_desc_fr)
        <div style="margin-top:20px;">
            <h3>Description courte</h3>
            <p>{{ $formation->short_desc_fr }}</p>
        </div>
    @endif

    @if($formation->full_desc_fr)
        <div style="margin-top:20px;">
            <h3>Description complète</h3>
            <p>{{ $formation->full_desc_fr }}</p>
        </div>
    @endif

    @if($formation->seo_title_fr)
        <div style="margin-top:20px;padding:10px;background:#f5f5f5;border-radius:8px;">
            <h3>SEO</h3>
            <p><strong>SEO Title:</strong> {{ $formation->seo_title_fr }}</p>
            <p><strong>Meta Desc:</strong> {{ $formation->meta_desc_fr }}</p>
        </div>
    @endif

@endsection
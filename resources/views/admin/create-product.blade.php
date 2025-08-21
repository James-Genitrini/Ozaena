@extends('layouts.app')

@section('title', 'Créer un produit')

@section('content')
    <div style="max-width: 800px; margin: 0 auto; padding: 2rem; background-color: #1a1a1a; border-radius: 12px;">
        <h2 style="font-size: 1.8rem; font-weight: 700; margin-bottom: 1.5rem; text-align: center; color: #F5F5F5;">Créer un
            produit</h2>

        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
            @csrf

            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: #F5F5F5;">Nom</label>
                <input type="text" name="name" class="form-input" required
                    style="width: 100%; padding: 0.6rem; border-radius: 6px; border: none; outline: none; background-color: #0D0D0D; color: #F5F5F5;">
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: #F5F5F5;">Slug (optionnel)</label>
                <input type="text" name="slug" class="form-input"
                    style="width: 100%; padding: 0.6rem; border-radius: 6px; border: none; outline: none; background-color: #0D0D0D; color: #F5F5F5;">
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: #F5F5F5;">Description</label>
                <textarea name="description" rows="4"
                    style="width: 100%; padding: 0.6rem; border-radius: 6px; border: none; outline: none; background-color: #0D0D0D; color: #F5F5F5;"></textarea>
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: #F5F5F5;">Prix (€)</label>
                <input type="text" name="price" required
                    style="width: 100%; padding: 0.6rem; border-radius: 6px; border: none; outline: none; background-color: #0D0D0D; color: #F5F5F5;">
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: #F5F5F5;">Image principale (avant)</label>
                <input type="file" name="main_image_front" accept="image/*">
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; margin-bottom: 0.5rem; color: #F5F5F5;">Image principale (arrière)</label>
                <input type="file" name="main_image_back" accept="image/*">
            </div>

            <button type="submit"
                style="background-color: #F5F5F5; color: #0D0D0D; padding: 0.8rem 1.5rem; border-radius: 8px; font-weight: 600; cursor: pointer;">
                Enregistrer
            </button>
        </form>
    </div>
@endsection
@props(['product'])

<a href="{{ route('produit.show', ['product' => $product->slug]) }}"
    class="group flex flex-col items-center cursor-pointer">
    <div class="w-64 h-64 relative overflow-hidden rounded-lg">
        <img src="{{ asset($product->main_image_front) }}" alt="{{ $product->name }} Front"
            class="w-full h-full object-contain transition-opacity duration-500 ease-in-out group-hover:opacity-0 absolute top-0 left-0" />
        <img src="{{ asset($product->main_image_back) }}" alt="{{ $product->name }} Back"
            class="w-full h-full object-contain transition-opacity duration-500 ease-in-out opacity-0 group-hover:opacity-100 absolute top-0 left-0" />
    </div>
    <h3 class="mt-4 text-lg font-semibold text-white-900">{{ $product->name }}</h3>
    <p class="text-white-600 mt-1 text-base">€{{ number_format($product->price, 2) }}</p>
</a>
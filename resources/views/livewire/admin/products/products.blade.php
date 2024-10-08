@section('breadcrumbs')
    @include('parts.breadcrumbs', ['links' => [
                                    [
                                        'url' => route('admin.home'),
                                        'name' => 'Home'
                                    ],
                                    [
                                        'url' => route('admin.products.index'),
                                        'name' => 'Products',
                                    ]]])
@endsection

<div>
    <div class="flex max-sm:gap-4 justify-between items-end mb-8">
        <div class="flex gap-8 w-full">
            @include('parts.form.input', [
                'title' => 'Search',
                'model' => 'searchText',
                'small' => true
            ])
            @include('parts.form.select', [
                'title' => 'Categories',
                'model' => 'selectedCategory',
                'options' => $categories,
                'value' => 'category_id',
                'name' => 'name',
                'small' => true,
                'placeholder' => 'All',
                'showPlaceholder' => true
            ])
        </div>

        <a href="{{ route('admin.products.create')}}" class="btn btn-primary btn-sm">
            <i class="ri-add-circle-line"></i>
        </a>
    </div>

    <div class="overflow-x-auto">
        <div wire:loading
             class="w-full h-full fixed top-0 left-0 bg-white opacity-75 z-50">
            <div class="flex justify-center items-center mt-[50vh]">
                <span class="loading loading-spinner w-[75px] text-neutral"></span>
            </div>
        </div>
        <table class="table">
            <!-- head -->
            <thead>
            <tr>
                <th class="cursor-pointer" wire:click="toggleSortColumn('id')">
                    <div class="flex items-center gap-1">
                        ID
                        @if($sortColumn == 'id')
                            @if($sortDirection == 'asc')
                                <i class="ri-arrow-up-line mt-0.5"></i>
                            @else
                                <i class="ri-arrow-down-line mt-0.5"></i>
                            @endif
                        @else
                            <i class="ri-arrow-up-down-line mt-0.5"></i>
                        @endif
                    </div>
                </th>
                <th class="cursor-pointer" wire:click="toggleSortColumn('name')">
                    <div class="flex items-center gap-1">
                        Name
                        @if($sortColumn == 'name')
                            @if($sortDirection == 'asc')
                                <i class="ri-arrow-up-line mt-0.5"></i>
                            @else
                                <i class="ri-arrow-down-line mt-0.5"></i>
                            @endif
                        @else
                            <i class="ri-arrow-up-down-line mt-0.5"></i>
                        @endif
                    </div>
                </th>
                <th>Category</th>
                <th>Image</th>
                <th class="cursor-pointer" wire:click="toggleSortColumn('count')">
                    <div class="flex items-center gap-1">
                        Count
                        @if($sortColumn == 'count')
                            @if($sortDirection == 'asc')
                                <i class="ri-arrow-up-line mt-0.5"></i>
                            @else
                                <i class="ri-arrow-down-line mt-0.5"></i>
                            @endif
                        @else
                            <i class="ri-arrow-up-down-line mt-0.5"></i>
                        @endif
                    </div>
                </th>
                <th class="cursor-pointer" wire:click="toggleSortColumn('price')">
                    <div class="flex items-center gap-1">
                        Price
                        @if($sortColumn == 'price')
                            @if($sortDirection == 'asc')
                                <i class="ri-arrow-up-line mt-0.5"></i>
                            @else
                                <i class="ri-arrow-down-line mt-0.5"></i>
                            @endif
                        @else
                            <i class="ri-arrow-up-down-line mt-0.5"></i>
                        @endif
                    </div>
                </th>
                <th class="cursor-pointer" wire:click="toggleSortColumn('available')">
                    <div class="flex items-center gap-1">
                        Visible
                        @if($sortColumn == 'available')
                            @if($sortDirection == 'asc')
                                <i class="ri-arrow-up-line mt-0.5"></i>
                            @else
                                <i class="ri-arrow-down-line mt-0.5"></i>
                            @endif
                        @else
                            <i class="ri-arrow-up-down-line mt-0.5"></i>
                        @endif
                    </div>
                </th>
                <th class="cursor-pointer" wire:click="toggleSortColumn('vendor_code')">
                    <div class="flex items-center gap-1">
                        Vendor code
                        @if($sortColumn == 'vendor_code')
                            @if($sortDirection == 'asc')
                                <i class="ri-arrow-up-line mt-0.5"></i>
                            @else
                                <i class="ri-arrow-down-line mt-0.5"></i>
                            @endif
                        @else
                            <i class="ri-arrow-up-down-line mt-0.5"></i>
                        @endif
                    </div>
                </th>
                <th></th>
            </tr>
            </thead>
            <tbody>

            @foreach($products as $product)
                <tr class="hover">
                    <td class="font-black">{{$product->id}}</td>
                    <td class="max-w-[200px]"><a href="{{ route('admin.products.show', compact('product')) }}">{{$product->full_title}}</a></td>
                    <td class="">
                        @include('parts.table.photo', [
                            'url' => $product->category?->photo?->url,
                            'alt' => $product->category->name,
                            'name' => $product->category->name
                        ])
                    </td>
                    <td>
                        <div class="avatar">
                            <div class="w-12 rounded-xl">
                                <img src="{{ $product->firstPhoto->url ?? '' }}" onerror="this.src='{{ App\Models\Photo::IMAGE_NOT_FOUND }}';"/>
                            </div>
                        </div>
                    </td>
                    <td>{{ $product->count }}</td>
                    <td class="font-bold">{{ $product->formatted_price }} ₴</td>
                    <td>
                        <input type="checkbox" class="toggle" wire:click="toggleVisible('{{ $product->id }}')" @if($product->available) checked @endif/>
                    </td>
                    <td class="break-words max-w-[100px]">{{ $product->vendor_code }}</td>
                    <td>
                        <div class="flex gap-1 items-center">
                            <a  class="btn btn-sm border-2 border-gray-200 hover:shadow-neutral-600 hover:shadow-sm" href="{{ route('admin.products.seo', compact('product')) }}">
                                <img src="{{ asset('images/icons/seo-fill.svg') }}" alt="SEO" width="14" height="14">
                            </a>
                            <a class="btn btn-sm border-2 border-gray-200 hover:shadow-neutral-600 hover:shadow-sm" href="{{ route('admin.products.show', compact('product')) }}">
                                <i class="ri-eye-line"></i>
                            </a>
                            <a class="btn btn-sm border-2 border-gray-200 hover:shadow-neutral-600 hover:shadow-sm" href="{{route('admin.products.edit', $product)}}">
                                <i class="ri-pencil-line"></i>
                            </a>

                            <button type="button" class="btn btn-sm btn-danger bg-red-600 hover:bg-red-700 text-white" wire:click="toggleDeleteModal('{{ $product->id }}')">
                                <i class="ri-delete-bin-line"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    @include('parts.delete-modal', [
        'model' => $deleteProduct,
        'open' => $open,
        'deleteMethod' => 'delete',
        'toggleMethod' => 'toggleDeleteModal',
        'transPath' => 'pages.admin.products.delete',
    ])

{{--    <div class="flex gap-3 justify-end my-5">--}}
{{--        @if(isset($deleteProduct))--}}
{{--        <dialog id="modal" class="modal modal-vertical modal-sm" @if($open) open @endif>--}}
{{--            <div class="w-screen h-screen relative  bg-base-content opacity-40">--}}
{{--            </div>--}}
{{--            <form wire:submit="delete" method="dialog" class="modal-box absolute top-2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 opacity-100">--}}
{{--                <div class="mt-2 flex justify-center">--}}
{{--                    <button type="button" wire:click="toggleDeleteModal" class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>--}}
{{--                </div>--}}
{{--                <div class="flex flex-wrap justify-center gap-5">--}}
{{--                    <div class="font-extrabold text-xl flex justify-center">--}}
{{--                        {{ trans('pages.admin.products.delete') }}--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="mt-3 text-center text-lg">--}}
{{--                    Are you sure you want to delete--}}
{{--                    <span class="font-bold">{{ $deleteProduct->name }}</span>--}}
{{--                    ?--}}
{{--                </div>--}}
{{--                <div class="flex gap-3 justify-center mt-6">--}}
{{--                    <button type="submit" class="btn bg-red-600 hover:bg-red-700 text-white">Delete</button>--}}
{{--                    <button type="button" wire:click="toggleDeleteModal" class="btn">Cancel</button>--}}
{{--                </div>--}}
{{--            </form>--}}
{{--        </dialog>--}}
{{--        @endif--}}
{{--    </div>--}}

    {{ $products->links() }}
</div>

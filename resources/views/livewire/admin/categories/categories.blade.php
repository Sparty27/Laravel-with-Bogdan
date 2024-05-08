<div class="overflow-x-auto">
    <div class="flex justify-center relative my-9">
        <a href="{{ route('admin.categories.create')}}" class="btn btn-primary mb-8 absolute left-0">Create</a>
        <div class="flex items-center gap-4">
            <span class="font-bold text-2xl">Search</span>
            <input type="text" placeholder="Type here" class="input input-bordered w-full max-w-xs" wire:model.live="searchText"/>
        </div>
    </div>

    <table class="table">
        <!-- head -->
        <thead>
        <tr>
            <th class="cursor-pointer" wire:click="toggleSortColumn('id')">
                <div class="flex items-center">
                    ID
                    @if($sortColumn == 'id')
                        @if($sortDirection == 'asc')
                            <i class="ri-arrow-up-line mt-[2px]"></i>
                        @else
                            <i class="ri-arrow-down-line mt-[2px]"></i>
                        @endif
                    @else
                        <i class="ri-arrow-up-down-line mt-[2px]"></i>
                    @endif
                </div>
            </th>
            <th>Image</th>
            <th class="cursor-pointer" wire:click="toggleSortColumn('name')">
                <div class="flex items-center">
                    Name
                    @if($sortColumn == 'name')
                        @if($sortDirection == 'asc')
                            <i class="ri-arrow-up-line mt-[2px]"></i>
                        @else
                            <i class="ri-arrow-down-line mt-[2px]"></i>
                        @endif
                    @else
                        <i class="ri-arrow-up-down-line mt-[2px]"></i>
                    @endif
                </div>
            </th>
            <th class="cursor-pointer" wire:click="toggleSortColumn('created_at')">
                <div class="flex items-center">
                    Created At
                    @if($sortColumn == 'created_at')
                        @if($sortDirection == 'asc')
                            <i class="ri-arrow-up-line mt-[2px]"></i>
                        @else
                            <i class="ri-arrow-down-line mt-[2px]"></i>
                        @endif
                    @else
                        <i class="ri-arrow-up-down-line mt-[2px]"></i>
                    @endif
                </div>
            </th>
            <th class="cursor-pointer" wire:click="toggleSortColumn('updated_at')">
                <div class="flex items-center">
                    Updated At
                    @if($sortColumn == 'updated_at')
                        @if($sortDirection == 'asc')
                            <i class="ri-arrow-up-line mt-[2px]"></i>
                        @else
                            <i class="ri-arrow-down-line mt-[2px]"></i>
                        @endif
                    @else
                        <i class="ri-arrow-up-down-line mt-[2px]"></i>
                    @endif
                </div>
            </th>
            <th></th>
        </tr>
        </thead>
        <tbody>

        @foreach($categories as $category)
            <tr class="hover">
                <td class="font-black">{{$category->id}}</td>
                <td>
                    <div class="flex items-center gap-3">
                        <div class="avatar">
                            <div class="mask mask-squircle w-12 h-12">
                                <img src="{{ asset($category->photos()->value('url')) != asset('') ? asset($category->photos()->value('url')) : 'https://media.istockphoto.com/id/1409329028/vector/no-picture-available-placeholder-thumbnail-icon-illustration-design.jpg?s=612x612&w=0&k=20&c=_zOuJu755g2eEUioiOUdz_mHKJQJn-tDgIAhQzyeKUQ=' }}" alt="Avatar Tailwind CSS Component" />
                            </div>
                        </div>
                    </div>
                </td>
                <td><a href="{{ route('admin.categories.show', compact('category')) }}">{{$category->name}}</a>
                </td>
                <td>{{$category->created_at}}</td>
                <td>{{$category->updated_at}}</td>
                <td>
                    <a class="btn border-2 border-gray-200 hover:shadow-neutral-600 hover:shadow-sm" href="{{ route('admin.categories.show', compact('category')) }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $categories->links() }}
</div>

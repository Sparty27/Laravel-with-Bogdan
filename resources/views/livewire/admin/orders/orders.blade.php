<div x-cloak>
{{--    <div class="flex justify-between items-end mb-8">--}}
{{--        <div class="flex gap-8 w-full">--}}
{{--            @include('parts.form.input', [--}}
{{--                'title' => 'Search',--}}
{{--                'model' => 'searchText',--}}
{{--                'small' => true--}}
{{--            ])--}}
{{--        </div>--}}

{{--        <a href="{{ route('admin.tags.create')}}" class="btn btn-primary btn-sm">--}}
{{--            <i class="ri-add-circle-line"></i>--}}
{{--        </a>--}}
{{--    </div>--}}

{{--    <div x-data="{ expanded: false }" class="relative max-w-sm mx-auto">--}}
{{--        <div class="overflow-hidden" :class="{ 'max-h-52': !expanded }">--}}
{{--        </div>--}}

{{--        <button--}}
{{--            @click="expanded = !expanded"--}}
{{--            class="mt-2 text-blue-500 hover:text-blue-700 focus:outline-none w-full text-center">--}}
{{--            <span x-show="!expanded">Відобразити більше</span>--}}
{{--            <span x-show="expanded" x-cloak>Згорнути</span>--}}
{{--        </button>--}}
{{--    </div>--}}



    <div class="overflow-x-auto">
        <table class="table min-w-[1000px]">
            <!-- head -->
            <thead>
            <tr>
                <th class="cursor-pointer">
                    <div class="flex items-center gap-1">
                        ID
                    </div>
                </th>
                <th>
                    <div class="flex items-center gap-1">
                        Products
                    </div>
                </th>
                <th>Payment</th>
                <th>Delivery</th>
                <th>Order Status</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td class="font-black">
                            {{ $order->id }}
                        </td>
                        <td class="max-w-[200px]">
                            <div>
                                <div x-data="{
                                    expanded: false,
                                    showButton: false,
                                    init() {
                                    // Отримуємо фактичну висоту елемента після завантаження
                                    this.$nextTick(() => {
                                    const contentHeight = this.$refs.content.scrollHeight;
                                    this.showButton = contentHeight > 200; // Порівнюємо з порогом (200px)
                                    });
                                    }
                                    }"
                                    class="relative max-w-sm mx-auto">
                                    <div class="overflow-hidden transition-all duration-300"
                                        :class="{ 'max-h-52': !expanded }"
                                        x-ref="content">
                                        @foreach($order->orderProducts as $orderProduct)
                                            <div class="flex mt-1 gap-2 items-center">
                                                <div class="avatar">

                                                    <div class="rounded overflow-hidden w-[40px] min-w-[40px]">
                                                        <img src="{{ $orderProduct->product->firstPhoto->url ?? '' }}" onerror="this.src='{{ App\Models\Photo::IMAGE_NOT_FOUND }}';" width="40" height="40"/>
                                                    </div>
                                                </div>
                                                <div class="text-xs text-wrap break-words">
                                                    {{ $orderProduct->product == null ? $orderProduct->name : $orderProduct?->product?->name.' '.$orderProduct->product?->clothing->size }} x {{ $orderProduct->count }}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div
                                        x-show="!expanded && showButton"
                                        x-cloak
                                        class="absolute bottom-[25px] left-0 w-full h-20 bg-gradient-to-t from-white via-white/50 to-white/0">
                                    </div>

                                    <button
                                        x-show="showButton"
                                        @click="expanded = !expanded"
                                        class="mt-2 text-[#5A72A0] font-semibold hover:text-[#4f648c] focus:outline-none w-full text-center font-mono">
                                        <span x-show="!expanded">Відобразити більше</span>
                                        <span x-show="expanded" x-cloak>Згорнути</span>
                                    </button>
                                </div>


                                <div class="font-mono font-semibold tracking-tight mt-3 border-t-[1px] border-t-gray-200">
                                    {{ number_format($order->formattedTotal(), 2, '.', ' ') }}₴
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="font-semibold font-mono text-xs uppercase tracking-wider flex flex-col gap-2 items-center">
                                <div class="border-[1px] rounded p-3 shadow">
                                    @switch($order->orderTransaction?->type)
                                        @case(\App\Enums\PaymentMethodEnum::MONOBANK)
                                            <img src="https://asset.brandfetch.io/id-CBRc8NA/idbiSfkx2x.svg" alt="monobank method" class="w-[60px]">
                                        @break
                                        @case(\App\Enums\PaymentMethodEnum::FONDY)
                                            <img src="{{ asset('images/fondy-main-light.svg') }}" alt="fondy method" class="w-[60px]">
                                        @break
                                    @endswitch
                                </div>

                                <div class="text-[10px]
                                    @switch($order->orderTransaction?->status)
                                        @case(\App\Enums\PaymentStatusEnum::SUCCESS)
                                        text-lime-600
                                        @break
                                        @case(\App\Enums\PaymentStatusEnum::PROCESS)
                                        text-blue-500
                                        @break
                                        @case(\App\Enums\PaymentStatusEnum::FAILED)
                                        text-red-700
                                        @break
                                    @endswitch
                                ">
                                    {{ trans('payment.'.$order->orderTransaction?->status->value) }}
                                </div>
                            </div>
                        </td>
                        <td class="max-w-[200px]">
                            <div class="font-semibold text-xs tracking-wider font-mono">
                                <div class="flex justify-between">
                                    <div>
                                        Новою Поштою
                                    </div>
                                    <div>
                                        <button wire:click="toggleModal('{{ $order->id }}')" class="px-2 py-0.5 rounded border-[1px] border-gray-400 shadow hover:bg-gray-200">
                                            <i class="ri-file-list-3-line text-base"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="font-normal text-[10px] text-gray-500" title="{{ $order->orderDelivery?->warehouse?->city?->name.', '.$order->orderDelivery?->warehouse?->name }}">
                                    <div>
                                        {{ $order->orderDelivery?->warehouse?->city?->name }}
                                    </div>
                                    <div>
                                        {{ $order->orderDelivery?->warehouse?->name }}
                                    </div>
                                </div>
                                @if($order->orderDelivery?->ttn != null)
                                    <div x-data="{ hover: false, clicked: false }" @mouseenter="hover = true" @mouseleave="hover = false" @click="clicked = true; setTimeout(() => clicked = false, 200)" :class="clicked ? 'text-green-500' : 'text-black'"  class="relative mt-3 font-bold text-[14px] text-gray-800 hover:cursor-pointer hover:opacity-75 duration-100" wire:click="copy('toCopyTTN{{ $order->orderDelivery->id }}')">
                                        ТТН:
                                        <span id="toCopyTTN{{ $order->orderDelivery->id }}">
                                            {{ $order->orderDelivery?->ttn }}
                                        </span>
                                        <span x-cloak x-show="hover" class="absolute -right-[10px]" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="opacity-0 transform scale-50" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-50">
                                            <i class="ri-clipboard-line"></i>
                                        </span>
                                    </div>
                                @endif
                                <div class="mt-3">
                                    {{ trans('delivery.'.$order->orderDelivery?->status->value) }}
                                </div>

{{--                                @switch($order->orderDelivery->status)--}}
{{--                                    @case(\App\Enums\DeliveryStatusEnum::PROCESS)--}}
{{--                                        process--}}
{{--                                        @break--}}
{{--                                    @case(\App\Enums\DeliveryStatusEnum::DELIVERIED)--}}
{{--                                        del--}}
{{--                                        @break--}}
{{--                                    @case(\App\Enums\DeliveryStatusEnum::CANCELED)--}}
{{--                                        text-red-700--}}
{{--                                        @break--}}
{{--                                    @case(\App\Enums\DeliveryStatusEnum::RETURNED)--}}
{{--                                        text-red-700--}}
{{--                                        @break--}}
{{--                                @endswitch--}}
                            </div>
                        </td>
                        <td>
                            <label class="form-control w-full max-w-xs">
                                <select class="select select-bordered w-full max-w-xs
                                        select-sm font-mono font-bold tracking-wider"
                                        wire:change="updateStatus({{ $order->id }}, $event.target.value)">
                                        <option value="" @if(!$order->status) selected @endif disabled>Оберіть стан замовлення</option>
                                    @foreach(\App\Enums\OrderStatusEnum::cases() as $option)
                                        <option @if($option == $order->status) selected @endif value="{{ $option->value }}">
                                            {{ $option->label() }}
                                        </option>
                                    @endforeach
                                </select>
                            </label>
                        </td>
                        <td>
                            <div class="flex gap-1 justify-end items-center">
                                <a class="btn btn-sm border-2 border-gray-200 hover:shadow-neutral-600 hover:shadow-sm" href="#">
                                    <i class="ri-eye-line"></i>
                                </a>
                                <a class="btn btn-sm border-2 border-gray-200 hover:shadow-neutral-600 hover:shadow-sm" href="{{ route('admin.orders.edit', compact('order')) }}">
                                    <i class="ri-pencil-line"></i>
                                </a>

                                <button type="button" class="btn btn-sm btn-danger bg-red-600 hover:bg-red-700 text-white" wire:click="toggleDeleteModal('{{ $order->id }}')">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
{{--            @foreach($tags as $tag)--}}
{{--                <tr class="hover">--}}
{{--                    <td class="font-black">{{$tag->id}}</td>--}}
{{--                    <td>{{$tag->name}}</td>--}}
{{--                    <td>--}}
{{--                        <input type="checkbox" class="toggle" wire:click="toggleVisible('{{ $tag->id }}')" @if($tag->status) checked @endif/>--}}
{{--                    </td>--}}
{{--                    <td>{{$tag->created_at}}</td>--}}
{{--                    <td>{{$tag->updated_at}}</td>--}}
{{--                    <td>--}}
{{--                        <div class="flex gap-3 items-center">--}}
{{--                            <a class="btn btn-sm border-2 border-gray-200 hover:shadow-neutral-600 hover:shadow-sm" href="{{route('admin.tags.edit', $tag)}}">--}}
{{--                                <i class="ri-pencil-line"></i>--}}
{{--                            </a>--}}

{{--                            <button type="button" class="btn btn-sm btn-danger bg-red-600 hover:bg-red-700 text-white" wire:click="toggleDeleteModal('{{ $tag->id }}')">--}}
{{--                                <i class="ri-delete-bin-line"></i>--}}
{{--                            </button>--}}
{{--                        </div>--}}
{{--                    </td>--}}
{{--                </tr>--}}
{{--            @endforeach--}}
            </tbody>
        </table>

        <div class="flex gap-3 justify-end my-5">
            <dialog id="modal" class="modal modal-vertical modal-sm" @if($open) open @endif>
                <div class="w-screen h-screen relative  bg-base-content opacity-40">
                </div>
                <form wire:submit="saveTTN" method="dialog" class="modal-box absolute top-2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 opacity-100">
                    <div class="mt-2 flex justify-center">
                        <button type="button" wire:click="toggleModal" class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
                    </div>
                    <div class="flex flex-wrap justify-start gap-5">
                        <div class="font-extrabold text-xl flex">
                            {{ trans( 'pages.admin.orders.save_ttn') }}
                        </div>
                    </div>
                    <div class="mt-8 text-center text-lg flex font-bold gap-3">
                        <div class="mt-[9px]">
                            ТТН:
                        </div>
                        @include('parts.form.input', [
                        'model' => 'ttn',
                        'placeholder' => '',
                        'attributes' => 'maxLength=17',
                        'mask' => '99 9999 9999 9999'
                    ])
                    </div>
                    <div class="flex gap-3 justify-center mt-6">
                        <button type="submit" class="btn bg-green-600 hover:bg-green-700 text-white">Save</button>
                        <button type="button" wire:click="toggleModal" class="btn">Cancel</button>
                    </div>
                </form>
            </dialog>
        </div>

        @include('parts.delete-modal', [
            'model' => $deleteOrder,
            'open' => $openDeleteModal,
            'deleteMethod' => 'delete',
            'toggleMethod' => 'toggleDeleteModal',
            'transPath' => 'pages.admin.modal.delete',
            'name' => 'id'
        ])

        {{--        @include('parts.delete-modal', [--}}
{{--            'model' => $deleteTag,--}}
{{--            'open' => $open,--}}
{{--            'deleteMethod' => 'delete',--}}
{{--            'toggleMethod' => 'toggleDeleteModal',--}}
{{--            'transPath' => 'pages.admin.tags.delete',--}}
{{--        ])--}}

        {{ $orders->links() }}
    </div>
</div>

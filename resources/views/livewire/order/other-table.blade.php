<div>
    <div class="border border-gray-300 rounded-lg p-1 flex flex-col h-64 justify-between flex-grow" x-data>
        <div class="flex">
            <div class="w-64 p-2 h-48">
                @if($order)
                <div>
                    <a href="{{ route('orders.show', ['action' => $action, 'order' => $order]) }}">
                        <ul class="list-unstyled text-xs">
                            <li>Order # {{ $order->order_number }}</li>
                            <li>Amount: ₱ {{number_format( $order->totalPrice(), 2, '.', ',') }}</li>
                            @if($order->action == "Delivery")
                            <li>Address: {{ $order->address }}</li>
                            <li>Contact: {{ $order->contact }}</li>
                            @else
                            <li>Pax: {{ $order->pax }}</li>
                            @endif
                            <li>Served by: {{ $order->waiter->full_name }}</li>
                        </ul>
                    </a>
                </div>

                @can('manage')
                <div class="flex flex-row mt-1 items-center space-x-2">
                    <button
                        class="text-xs py-1 px-2 rounded-md text-white {{  !$enableDiscount ? 'bg-green-500 hover:bg-green-700' : 'bg-red-500 hover:bg-red-700' }}"
                        wire:click="activateDiscount">{{ !$enableDiscount ? 'Enable Discount' : 'Disable'}}</button>
                    @if ($enableDiscount)
                    <button class="text-xs py-1 px-2 rounded-md text-white bg-green-500 hover:bg-green-700"
                        wire:click="discountSave">Save</button>
                    @endif
                    @if($isSaved)
                    <i class="fa fa-check text-green-500"></i>
                    @endif
                </div>
                @if($enableDiscount)
                <div class="flex flex-col mt-1 space-y-1">
                    <x-select class="h-8 text-xs" wire:model="discountType">
                        <option value="percent">{{ _('Percent') }}</option>
                        <option value="fixed">{{ _('Fixed') }}</option>
                    </x-select>
                    <x-input
                        class="text-right text-xs p-2 {{ $errors->get('discount') ? 'border border-red-500' : '' }}"
                        wire:model="discount" />
                </div>
                @endif
                @endcan

                @else
                Empty
                @endif

            </div>
            <div class="flex items-center w-8">
                <button type="button" class="w-5" @if(!empty($order))
                    wire:click.prevent="$emitTo('auth.passcode', 'voidPasscode', {{ $order->id }}, 1)">
                    @endif
                    <i class="fa fa-trash {{ Gate::check('manage') ? 'text-red-500' : 'text-gray-200' }}"></i>
                </button>
            </div>
        </div>
        <div class="rounded-b-lg text-center text-sm font-bold">
            <div class="flex items-end">
                <div class="w-full">
                    <livewire:order.modal.billing-type :billingType="$order->billing_type"
                        :order="$order" key="billing-{{ $order->id }}" />
                </div>
                <button class="w-full {{ count($order->orderReceipts) > 0 ? 'text-red-500' : 'text-gray-300' }} font-bold" type="button" {{ count($order->orderReceipts) > 0 ? '' : 'disabled' }}
                    x-on:click="window.livewire.emitTo('order.checkout', 'checkOut', {{ $order->id }})">
                    Check out
                </button>

            </div>

        </div>
    </div>

</div>
<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Report') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-2 lg:px-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="py-6 bg-white border-b border-gray-200">
                    <div class="px-6" x-data="setup()">

                        <div class="text-right">
                            <x-button type="button" wire:click="save()">Save Report</x-button>
                        </div>

                        <div class="flex justify-end mx-6 py-2">

                            <div class="flex space-x-3 items-center">
                                <button wire:click="prevDate"><i class="fa fa-arrow-left"></i></button>
                                <x-input type="date" class="w-auto text-sm" wire:model="date" />
                                <button wire:click="nextDate"><i class="fa fa-arrow-right"></i></button>
                            </div>
                        </div>

                        @error('remit')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror

                        <div class="grid grid-flow-row grid-cols-2 gap-4">
                            @foreach ($overalls as $overall)
                                <div>
                                    <span class="uppercase">

                                        {{ $overall->name }}
                                    </span>
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col"
                                                    class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center w-1/4">Item</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center w-1/4"></th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">Quantity</th>
                                                <th scope="col"
                                                    class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach ($overall->dishes as $dish)
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                        {{ $dish->name }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
                                                        {{ $dish->properties }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
                                                        {{ $dish->orderDetails->sum('pcs') }}
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right">
                                                        {{ '₱ '. number_format($dish->orderDetails->sum('price'), 2, '.', ',') }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot class="bg-gray-50">
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">Total</td>
                                                <td></td>
                                                <td></td>
                                                <td class="px-6 py-4 whitespace-nowrap font-bold text-lg text-right">{{'₱ '. number_format( $overall->dishes->sum(function ($dish) { return $dish->orderDetails->sum('price'); }) , 2, '.', ',') }}</td>
                                            </tr>
                                        </tfoot>
                                    </table>

                                </div>
                            @endforeach



                        </div>

                        <div class="grid grid-flow-row grid-cols-2 gap-4">
                            <div>
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center w-full">Spoilage</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center w-20">Quantity</th>
                                            <th scope="col" class="relative px-6 py-3">
                                                <div>
                                                    <button type="button" class="bg-green-500 hover:bg-green-300 text-white rounded shadow-sm h-10 w-10 items-center" @click="addSpoilage">+</button>
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <template x-for="(spoil, index) in spoilages" :key="index">
                                            <tr>
                                                <td class="whitespace-nowrap text-sm text-gray-900">
                                                    <x-select x-model="spoil.dish" class="w-full block">
                                                        <option value=" " hidden>Select</option>
                                                        <template x-for="(dish, i) in dishes" :key="i">
                                                            <option :value="dish.name +` | `+dish.properties" x-text="dish.name + ` | ` + dish.properties"></option>
                                                        </template>
                                                    </x-select>
                                                </td>
                                                <td class="whitespace-nowrap text-sm text-gray-900 text-center">
                                                    <x-input type="text" x-model="spoil.quantity" class=" w-20"></x-input>
                                                </td>
                                                <td class="whitespace-nowrap text-sm text-gray-900 text-center">
                                                    <div>
                                                        <button type="button" class="bg-red-500 hover:bg-red-300 text-white rounded shadow-sm h-10 w-10 items-center" @click="removeSpoilage(index)">-</button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>

                            <div>
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center w-full">Purchases</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center w-full">Price</th>
                                            <th scope="col" class="relative px-6 py-3">
                                                <div>
                                                    <button type="button" class="bg-green-500 hover:bg-green-300 text-white rounded shadow-sm h-10 w-10 items-center" @click="addPurchase">+</button>
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <template x-for="(purchase, index) in purchases" :key="index">
                                            <tr>
                                                <td class="whitespace-nowrap text-sm text-gray-900">
                                                    <x-input type="text" x-model="purchase.name" class="block w-full"></x-input>
                                                </td>
                                                <td class="whitespace-nowrap text-sm text-gray-900 text-center">
                                                    <x-input type="number" x-model.number="purchase.price" class="block w-full" min=0></x-input>
                                                </td>
                                                <td class="whitespace-nowrap text-sm text-gray-900 text-center">
                                                    <div>
                                                        <button type="button" class="bg-red-500 hover:bg-red-300 text-white rounded shadow-sm h-10 w-10 items-center" @click="removePurchase(index)">-</button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </template>
                                    </tbody>
                                    <tfoot>
                                        <tr class="bg-gray-200 py-3">
                                            <td class="whitespace-nowrap text-sm text-gray-900 text-right">Total</td>
                                            <td class="whitespace-nowrap text-sm text-gray-900 text-center"><span x-text="getTotalPurchase()"></span></td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                        </div>

                        <hr class="my-2">

                        <div class="mt-2">
                            @foreach ($overalls as $overall)
                                <div class="mb-1 flex justify-between w-1/2 px-3">
                                    <div>
                                        {{ $overall->name }}
                                    </div>
                                    <div class='flex justify-between w-1/3'>
                                        <div>
                                            ₱
                                        </div>
                                        <div>
                                            {{number_format( $overall->dishes->sum(function ($dish) { return $dish->orderDetails->sum('price'); }) , 2, '.', ',') }}
                                        </div>
                                    </div>

                                </div>
                            @endforeach

                            <div class="w-1/2">
                                <hr>
                            </div>
                            <div class="flex justify-between w-1/2 px-3 font-bold mb-1">
                                <div>
                                    Total
                                </div>
                                <div class="flex justify-between w-1/3">
                                    <div>
                                        ₱
                                    </div>
                                    <div>
                                        {{
                                            number_format( $total, 2, '.', ',')
                                        }}
                                    </div>
                                </div>
                            </div>

                            @foreach ($latePayments as $late)
                                <div class="flex items-center justify-between w-1/2 px-3 mb-1">
                                    <div>
                                        {{ $late->full_name }} {{ $late->by ? "care off {$late->by}" : "" }}  ({{$late->paid_on->format('M d')}})
                                    </div>
                                    <div class="flex justify-between w-1/3">
                                        <div>
                                            ₱
                                        </div>
                                        <div>
                                            {{ number_format($late->total, 2, '.', ',') }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach


                            <div class="w-1/2">
                                <hr>
                            </div>
                            <div class="flex justify-between w-1/2 px-3 font-bold py-1 bg-yellow-300 rounded">
                                <div>
                                    Total Unpaid
                                </div>
                                <div class="flex justify-between w-1/3">
                                    <div>
                                        ₱
                                    </div>
                                    <div>
                                        <span x-text="getTotalUnpaid()"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="w-1/2">
                                <hr>
                            </div>
                            <div class="flex justify-between w-1/2 px-3 font-bold py-1 bg-yellow-300 rounded">
                                <div>
                                    Total Purchases
                                </div>
                                <div class="flex justify-between w-1/3">
                                    <div>
                                        ₱
                                    </div>
                                    <div>
                                        <span x-text="getTotalPurchase()"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="w-1/2">
                                <hr>
                            </div>
                            <div class="flex justify-between w-1/2 px-3 font-bold py-1">
                                <div>
                                    Total Sales
                                </div>
                                <div class="flex justify-between w-1/3">
                                    <div>
                                        ₱
                                    </div>
                                    <div>
                                        <span x-text="getTotalSales()"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="w-1/2">
                                <hr>
                            </div>
                            <div class="flex justify-between w-1/2 px-3 font-bold py-1">
                                <div>
                                    GCash
                                </div>
                                <div class="flex justify-between w-1/3">
                                    <div>
                                        ₱
                                    </div>
                                    <div>
                                        <span x-text="getGcash()"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="w-1/2 my-1">
                                <hr>
                            </div>
                            <div class="flex items-center justify-between w-1/2 px-3 py-1">

                                <div>
                                    Cash
                                </div>
                                <div class="flex justify-between w-1/3">
                                    <div>
                                        ₱
                                    </div>
                                    <div>
                                        <x-input type="text" class="text-xs text-right" x-model.number="remit"></x-input>
                                    </div>
                                </div>
                            </div>

                            <div class="w-1/2">
                                <hr>
                            </div>
                            <div class="flex justify-between w-1/2 px-3 font-bold py-1 bg-green-500 rounded">
                                <div>
                                    Total Remittance
                                </div>
                                <div class="flex justify-between w-1/3">
                                    <div>
                                        ₱
                                    </div>
                                    <div>
                                        <span x-text="getTotalRemittance()"></span>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>

    function setup() {
        return {
            date1: @entangle('date'),
            date2: @entangle('date2'),
            spoilages: @entangle('spoilages').defer,
            purchases: @entangle('purchases').defer,
            dishes: @entangle('dishes').defer,
            remit: @entangle('remit').defer,
            total: @entangle('total'),
            late: @entangle('lateTotal'),
            gcash: @entangle('gcash'),
            totalRemittance: @entangle('totalRemittance').defer,
            totalPurchases: @entangle('totalPurchases').defer,
            totalUnpaid: @entangle('totalUnpaid').defer,
            totalSales: @entangle('totalSales').defer,
            init(){
                this.totalRemittance = 0
            },
            addSpoilage() {
                this.spoilages.push({
                    'dish' : '',
                    'quantity': 1,
                })
            },
            removeSpoilage(index) {
                this.spoilages.splice(index, 1)
            },
            addPurchase() {
                this.purchases.push({
                    'name' : '',
                    'price' : 0,
                })
            },
            removePurchase(index) {
                this.purchases.splice(index, 1)
            },
            getTotalPurchase(){
                this.totalPurchases = 0
                this.purchases.forEach(element => {
                    this.totalPurchases += element.price
                });

                return numberWithCommas(this.totalPurchases)
            },
            getTotalUnpaid(){
                return numberWithCommas(this.totalUnpaid)
            },
            getTotalSales(){
                this.totalSales = this.total + this.late - this.totalUnpaid - this.totalPurchases
                return numberWithCommas(this.totalSales)
            },
            getGcash(){
                return numberWithCommas(this.gcash)
            },
            getTotalRemittance(){
                this.totalRemittance = this.gcash + this.remit
                return numberWithCommas(this.totalRemittance)
            },
        }
    };

    function numberWithCommas(x) {
        return x.toFixed(2).toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
    }

</script>

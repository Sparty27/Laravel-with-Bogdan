<?php

namespace App\Livewire\Site\Pages;

use App\Enums\MessageTypeEnum;
use App\Enums\PaymentMethodEnum;
use App\Models\City;
use App\Models\Warehouse;
use App\Services\OrderService\MakeOrderService;
use App\Services\OrderService\Models\Customer;
use App\Services\PaymentServices\FondyService\FondyService;
use App\Services\PaymentServices\MonobankService\MonobankService;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Mockery\Exception;

class MakeOrder extends Component
{
    #[Validate('required|string|min:5|max:190')]
    public $email = '';

    #[Validate('required|string|min:8|max:25')]
    public $phone = '';

    #[Validate('required|string|min:5|max:190')]
    public $name = '';

    #[Validate('required|string|min:5|max:190')]
    public $lastName = '';

    #[Validate('required', message: 'Потрібно вибрати спосіб оплати')]
    public PaymentMethodEnum $selectedPaymentMethod;

    #[Validate('required', message: 'Потрібно вибрати місто')]
    public City $selectedCity;

    #[Validate('required', message: 'Потрібно вибрати відділення')]
    public Warehouse $selectedWarehouse;

    public $searchCity;

    public $searchWarehouse;

    public $cities;
    public $warehouses;

    public $basketProducts;

    public function mount()
    {
        $this->cities = City::take(10)->get();
        $this->warehouses = Warehouse::take(10)->get();

        $this->basketProducts = basket()->getBasketProducts();
    }

    public function setPaymentMethod(PaymentMethodEnum $method)
    {
        $this->selectedPaymentMethod = $method;
    }

    public function updatedSearchCity($value)
    {
        $this->cities = City::search($value)->take(10)->get();
    }

    public function updatedSearchWarehouse($value)
    {
        $this->warehouses = $this->selectedCity->warehouses()->search($value)->take(10)->get();
    }

    public function selectCity(City $city)
    {
        $this->resetErrorBag('selectedCity');

        $this->searchCity = $city->name;
        $this->selectedCity = $city;

//        $this->selectedWarehouse =

        unset($this->selectedWarehouse);
        $this->searchWarehouse = '';

        $this->warehouses = Warehouse::where('city_ref', $city->ref)->get();
    }

    public function selectWarehouse(Warehouse $warehouse)
    {
        $this->resetErrorBag('selectedWarehouse');

        $this->searchWarehouse = $warehouse->name;
        $this->selectedWarehouse = $warehouse;
    }

    public function makeOrder(MakeOrderService $service, MonobankService $monobankService, FondyService $fondyService)
    {
        try {
            $this->validate();
        } catch(\Exception $e) {
            foreach($e->validator->errors()->all() as $errorMessage)
            {
                $this->dispatch('showPopup', $errorMessage, MessageTypeEnum::DANGER, 2000);
            }

            throw $e;
        }

        $customer = new Customer($this->name, $this->email, $this->phone);

        try {
            $order = $service->make($customer, $this->selectedWarehouse, $this->selectedPaymentMethod);

            switch($this->selectedPaymentMethod)
            {
                case PaymentMethodEnum::MONOBANK:
                    $url = $monobankService->checkout($order->orderTransaction);
                    break;
                case PaymentMethodEnum::FONDY:
                    $url = $fondyService->checkout($order->orderTransaction);
                    break;
                default:
                    $url = '';
                    break;
            }

            redirect($url);

        } catch(Exception $ex) {
            Log::info($ex->getMessage());
        }

        basket()->clear();
    }

    #[On('basketUpdated')]
    public function render()
    {
        return view('livewire.site.pages.make-order');
    }
}

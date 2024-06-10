<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\PaymentDriver;
use App\Models\Settings;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Inertia\Response;

class PaymentDriverController extends Controller
{
    public function index(): Response
    {
        $payments = PaymentDriver::all();

        return inertia('PaymentDriver/ListPaymentsDriver', [
            'payments' => $payments->load('user'),
        ]);
    }

    public function create()
    {
        $user = User::find(Auth::id());

        if ($user->isAdmin()) {

            $drivers = User::whereJsonContains('roles', 'driver')->get();

            if ($drivers->isEmpty()) {
                return redirect()->route('usuarios.create')->with('error', 'Não existem motoristas para pagar.');
            }

            return inertia('PaymentDriver/Create', [
                'drivers' => $drivers,
                'cars' => Car::all()
            ]);
        }

        return redirect()->route('dashboard');
    }


    public function store(Request $request)
    {
        $user = User::find(Auth::user()->id);
        if ($user->isAdmin()) {
            $request->validate([
                'date' => 'required|date|before_or_equal:today',
                'user_id' => 'required|exists:users,id',
                'valueWeek' => 'required|numeric',
                'paymentMethod' => 'required|in:IBAN,MONEY,MB-WAY',
                'platform' => 'required|in:uber,bolt',
                'slotValue' => 'numeric',
                'viaVerdeValue' => 'numeric',
                'frotaCardValue' => 'numeric|min:0',
            ]);

            $driver = User::find($request->user_id);
            $settings = Settings::first();

            $value = $request->valueWeek * $user->profitPercentage / 100;
            $paymentDriver = new PaymentDriver();

            $paymentDriver->date = $request->date;
            $paymentDriver->user_id = $request->user_id;
            $paymentDriver->valueWeek = $value;
            $paymentDriver->slotValue = $request->slotValue;
            $paymentDriver->viaVerdeValue = $request->viaVerdeValue;
            $paymentDriver->taxPercentage = $settings->percentageTaxIVA / 100;
            $paymentDriver->taxValue = $value * $settings->percentageTaxIVA / 100;
            $paymentDriver->profitPercentage = $driver->profitPercentage;
            $paymentDriver->hasCar = $driver->hasCar;
            $paymentDriver->rentValue = !$driver->hasCar ? $driver->rentValue : 0;
            $paymentDriver->totalValue = $value - $paymentDriver->taxValue - $paymentDriver->rentValue;
            $paymentDriver->paymentMethod = $request->paymentMethod;
            $paymentDriver->platform = $request->platform;
            $paymentDriver->frotaCardValue = $request->frotaCardValue;

            $paymentDriver->save();

            return redirect()->route('dashboard')->with('success', 'Pagamento criado.');
        }
        return redirect()->route('dashboard');
    }

    public function show(PaymentDriver $payment)
    {
        $drivers = User::whereJsonContains('roles', 'driver')->get();

        if ($drivers->isEmpty()) {
            return redirect()->route('usuarios.create')->with('error', 'Não existem motoristas para pagar.');
        }

        return inertia('PaymentDriver/Show', [
            'payment' => $payment->load('user'),
            'drivers' => $drivers,
            'cars' => Car::all()
        ]);
    }

    public function edit(PaymentDriver $paymentDriver)
    {
        $user = User::find(Auth::user()->id);
        if ($user->isAdmin()) {
            return inertia('PaymentDriver/Edit', [
                'paymentDriver' => $paymentDriver->load('user')
            ]);
        }
        return redirect()->route('dashboard');
    }

    public function update(Request $request, PaymentDriver $paymentDriver)
    {
        $user = User::find(Auth::user()->id);
        if ($user->isAdmin()) {
            $request->validate([
                'date' => 'required|date|before_or_equal:today',
                'valueWeek' => 'required|numeric',
                'taxPercentage' => 'required|numeric|min:0|max:100',
                'profitPercentage' => 'required|numeric|min:1|max:100',
                'hasCar' => 'required|boolean',
                'rentValue' => 'numeric|min:0',
                'paymentMethod' => 'required|in:IBAN,MONEY,MB-WAY',
                'paymentStatus' => 'required|in:PENDING,PAID',
            ]);

            $value = $request->valueWeek * $request->profitPercentage / 100;

            $paymentDriver->date = $request->date;
            $paymentDriver->valueWeek = $value;
            $paymentDriver->taxValue = $value * ($request->taxPercentage ? $request->taxPercentage / 100 : 1);
            $paymentDriver->profitPercentage = $request->profitPercentage;
            $paymentDriver->hasCar = $request->hasCar;
            $paymentDriver->rentValue = $request->rentValue;
            $paymentDriver->totalValue = $value - $paymentDriver->taxValue - $paymentDriver->rentValue;
            $paymentDriver->paymentMethod = $request->paymentMethod;
            $paymentDriver->paymentStatus = $request->paymentStatus;


            $paymentDriver->save();

            return redirect()->route('paymentDrivers.index')->with('success', 'Pagamento atualizado.');
        }
        return redirect()->route('dashboard');
    }

    public function destroy(PaymentDriver $paymentDriver)
    {
        $user = User::find(Auth::user()->id);
        if ($user->isAdmin()) {
            $paymentDriver->delete();

            return redirect()->route('paymentDrivers.index')->with('success', 'Pagamento eliminado.');
        }
        return redirect()->route('dashboard');
    }
}

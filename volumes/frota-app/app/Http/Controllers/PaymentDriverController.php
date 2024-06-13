<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\PaymentDriver;
use App\Models\Settings;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Response;

class PaymentDriverController extends Controller
{
    public function index(Request $request): Response
    {
        $this->authorize('viewAny', PaymentDriver::class);

        $user = $request->user();

        if ($user->isAdmin) {
            $payments = PaymentDriver::all();
        } else {
            $payments = $user->paymentsDriver;
        }

        return inertia('PaymentDriver/ListPaymentsDriver', [
            'payments' => $payments->load('user'),
        ]);
    }
    public function create(Request $request)
    {
        $this->authorize('create', PaymentDriver::class);

        $drivers = User::whereJsonContains('roles', 'driver')->get();

        if ($drivers->isEmpty()) {
            return redirect()->route('usuarios.create')->with('error', 'Não existem motoristas para pagar.');
        }

        return inertia('PaymentDriver/Create', [
            'drivers' => $drivers,
            'cars' => Car::all(),
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create', PaymentDriver::class);
        $user = User::find(Auth::user()->id);
        $request->validate([
            'date' => 'required|date|before_or_equal:today|unique:payment_drivers,date,NULL,id,user_id,' . $request->user()->id,
            'user_id' => 'required|exists:users,id',
            'valueWeekUber' => 'required|numeric',
            'valueWeekBolt' => 'required|numeric',
            'paymentMethod' => 'required|in:IBAN,MONEY,MB-WAY',
            'slotValue' => 'numeric',
            'viaVerdeValue' => 'numeric',
            'frotaCardValue' => 'numeric|min:0',
        ]);

        $driver = User::find($request->user_id);
        $settings = Settings::first();

        $value = ($request->valueWeekUber + $request->valueWeekBolt) * $user->profitPercentage / 100;
        $paymentDriver = new PaymentDriver();

        $paymentDriver->date = $request->date;
        $paymentDriver->user_id = $request->user_id;
        $paymentDriver->valueWeekUber = $request->valueWeekUber * $user->profitPercentage / 100;
        $paymentDriver->valueWeekBolt = $request->valueWeekBolt * $user->profitPercentage / 100;
        $paymentDriver->slotValue = $request->slotValue;
        $paymentDriver->viaVerdeValue = $request->viaVerdeValue;
        $paymentDriver->taxPercentage = $settings->percentageTaxIVA;
        $paymentDriver->taxValue = $value * $settings->percentageTaxIVA / 100;
        $paymentDriver->profitPercentage = $driver->profitPercentage;
        $paymentDriver->hasCar = $driver->hasCar;
        $paymentDriver->rentValue = ! $driver->hasCar ? $driver->rentValue : 0;
        $paymentDriver->paymentMethod = $request->paymentMethod;
        $paymentDriver->frotaCardValue = $request->frotaCardValue;
        $paymentDriver->save();

        return redirect()->route('pagamentos.index')->with('success', 'Pagamento criado.');
    }

    public function show(PaymentDriver $payment)
    {
        $this->authorize('view', $payment);

        $drivers = User::whereJsonContains('roles', 'driver')->get();

        if ($drivers->isEmpty()) {
            return redirect()->route('usuarios.create')->with('error', 'Não existem motoristas para pagar.');
        }

        return inertia('PaymentDriver/Show', [
            'payment' => $payment->load('user'),
            'drivers' => $drivers,
            'cars' => Car::all(),
        ]);
    }

    public function edit(PaymentDriver $payment)
    {
        $this->authorize('update', $payment);

        return inertia('PaymentDriver/Edit', [
            'paymentDriver' => $payment->load('user'),
        ]);

    }

    public function update(Request $request, PaymentDriver $payment)
    {

        $request->validate([
            'date' => 'required|date|before_or_equal:today',
            'valueWeekUber' => 'required|numeric',
            'taxPercentage' => 'required|numeric|min:0|max:100',
            'profitPercentage' => 'required|numeric|min:1|max:100',
            'hasCar' => 'required|boolean',
            'rentValue' => 'numeric|min:0',
            'paymentMethod' => 'required|in:IBAN,MONEY,MB-WAY',
            'paymentStatus' => 'required|in:PENDING,PAID',
        ]);

        $payment->date = $request->date;
        $payment->valueWeekUber = $request->valueWeekUber * $request->profitPercentage / 100;
        $payment->valueWeekBolt = $request->valueWeekBolt * $request->profitPercentage / 100;
        $payment->taxPercentage = $request->taxPercentage;
        $payment->profitPercentage = $request->profitPercentage;
        $payment->hasCar = $request->hasCar;
        $payment->rentValue = $request->rentValue;
        $payment->paymentMethod = $request->paymentMethod;
        $payment->paymentStatus = $request->paymentStatus;
        $payment->frotaCardValue = $request->frotaCardValue;
        $payment->slotValue = $request->slotValue;

        $payment->save();

        return redirect()->route('pagamentos.index')->with('success', 'Pagamento atualizado.');
    }

    public function destroy(PaymentDriver $payment)
    {
        $this->authorize('delete', $payment);
        $payment->delete();

        return redirect()->route('pagamentos.index')->with('success', 'Pagamento eliminado.');
    }
}

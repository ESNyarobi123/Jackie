<?php

use Livewire\Component;
use App\Models\Subscription;

new class extends Component
{
    public $subscriptions = [];
    public $payments = [];
    public $stats = [];
    public $showAllPayments = false;

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $user = auth()->user();
        
        $this->subscriptions = $user->subscriptions()
            ->active()
            ->with('course')
            ->get()
            ->toArray();

        $query = $user->payments()
            ->paid()
            ->with('course')
            ->latest('paid_at');
            
        $this->payments = $this->showAllPayments 
            ? $query->get()->toArray()
            : $query->limit(5)->get()->toArray();
            
        // Calculate stats
        $totalPaid = $user->payments()->paid()->sum('amount');
        $this->stats = [
            'total_paid' => $totalPaid,
            'active_subscriptions' => count($this->subscriptions),
            'total_payments' => $user->payments()->paid()->count(),
            'this_month' => $user->payments()->paid()->whereMonth('paid_at', now()->month)->sum('amount'),
        ];
    }

    public function toggleShowAll()
    {
        $this->showAllPayments = !$this->showAllPayments;
        $this->loadData();
    }

    public function renewSubscription($subId)
    {
        $this->dispatch('notify', message: 'Opening renewal options...');
    }

    public function downloadReceipt($paymentId)
    {
        $this->dispatch('notify', message: 'Downloading receipt...');
    }
}; ?>

<div class="space-y-6">
    <!-- Stats Overview -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="glass-card p-4 text-center">
            <div class="text-2xl font-bold text-(--color-terra)">TSh {{ number_format($stats['total_paid'] ?? 0, 0) }}</div>
            <div class="text-xs text-[rgba(30,41,59,0.6)] mt-1">Total Paid</div>
        </div>
        <div class="glass-card p-4 text-center">
            <div class="text-2xl font-bold text-green-500">{{ $stats['active_subscriptions'] ?? 0 }}</div>
            <div class="text-xs text-[rgba(30,41,59,0.6)] mt-1">Active Subs</div>
        </div>
        <div class="glass-card p-4 text-center">
            <div class="text-2xl font-bold text-blue-500">{{ $stats['total_payments'] ?? 0 }}</div>
            <div class="text-xs text-[rgba(30,41,59,0.6)] mt-1">Payments</div>
        </div>
        <div class="glass-card p-4 text-center">
            <div class="text-2xl font-bold text-purple-500">TSh {{ number_format($stats['this_month'] ?? 0, 0) }}</div>
            <div class="text-xs text-[rgba(30,41,59,0.6)] mt-1">This Month</div>
        </div>
    </div>

    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-(--color-smoke)">Payments & Subscription</h1>
            <p class="text-sm text-[rgba(30,41,59,0.65)] mt-1">Manage your payments and subscriptions</p>
        </div>
        <a href="{{ route('home') }}#courses" class="btn-premium text-sm">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Buy Course
        </a>
    </div>

    <!-- Active Subscriptions -->
    <div class="glass-card p-5 glass-elevated" style="background: linear-gradient(135deg, rgba(34,197,94,0.08), rgba(255,255,255,0.6));">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold text-(--color-smoke)">Active Subscriptions</h2>
            <span class="pill pill-green">Active</span>
        </div>
        
        @forelse($subscriptions as $sub)
            <div class="mb-4 pb-4 border-b border-[rgba(30,41,59,0.08)] last:border-0 last:mb-0 last:pb-0">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="font-semibold text-(--color-smoke)">{{ $sub['course']['title'] ?? 'Course' }}</h3>
                        <p class="text-sm text-[rgba(30,41,59,0.6)]">
                            Expires: {{ \Carbon\Carbon::parse($sub['access_ends_at'])->format('M d, Y') }}
                            ({{ \Carbon\Carbon::parse($sub['access_ends_at'])->diffForHumans() }})
                        </p>
                    </div>
                    <button wire:click="renewSubscription({{ $sub['id'] }})" class="btn-premium text-sm">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 4 23 10 17 10"/><polyline points="1 20 1 14 7 14"/><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"/></svg>
                        Renew
                    </button>
                </div>
            </div>
        @empty
            <div class="text-center py-6">
                <div class="w-16 h-16 mx-auto mb-3 rounded-full bg-[rgba(30,41,59,0.06)] flex items-center justify-center text-2xl">📭</div>
                <p class="text-[rgba(30,41,59,0.6)]">No active subscriptions</p>
                <a href="{{ route('home') }}#courses" class="text-sm text-(--color-terra) hover:underline mt-2 inline-block">Browse courses →</a>
            </div>
        @endforelse
    </div>

    <!-- Payment History -->
    <div class="glass-card p-5 glass-soft-shadow">
        <h2 class="text-lg font-bold text-(--color-smoke) mb-4">Payment History</h2>
        <div class="space-y-2">
            @forelse($payments as $payment)
                <div class="flex items-center justify-between p-3 rounded-lg bg-[rgba(255,255,255,0.4)]">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg shrink-0 flex items-center justify-center text-lg bg-[rgba(245,130,32,0.1)]">💳</div>
                        <div>
                            <h4 class="font-medium text-sm text-(--color-smoke)">{{ $payment['course']['title'] ?? 'Course Payment' }}</h4>
                            <p class="text-xs text-[rgba(30,41,59,0.5)]">{{ \Carbon\Carbon::parse($payment['paid_at'])->format('M d, Y') }} • {{ $payment['provider'] ?? 'M-Pesa' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                    <span class="pill pill-green font-mono">TSh {{ number_format($payment['amount'], 0) }}</span>
                    <button wire:click="downloadReceipt({{ $payment['id'] }})" class="p-1.5 rounded-lg hover:bg-[rgba(30,41,59,0.06)] transition-colors" title="Download Receipt">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                    </button>
                </div>
                </div>
            @empty
                <div class="text-center py-6">
                    <div class="w-16 h-16 mx-auto mb-3 rounded-full bg-[rgba(30,41,59,0.06)] flex items-center justify-center text-2xl">💳</div>
                    <p class="text-[rgba(30,41,59,0.6)]">No payments made yet</p>
                </div>
            @endforelse
        </div>
        @if($stats['total_payments'] > 5)
            <div class="mt-4 text-center">
                <button wire:click="toggleShowAll" class="btn-glass-outline text-sm">
                    {{ $showAllPayments ? 'Show Less' : 'View All Payments' }}
                </button>
            </div>
        @endif
    </div>

    <!-- Payment Methods -->
    <div class="glass-card p-5 glass-soft-shadow">
        <h2 class="text-lg font-bold text-(--color-smoke) mb-4">Available Payment Methods</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
            <div class="flex items-center gap-3 p-3 rounded-xl bg-[rgba(255,255,255,0.6)] border border-[rgba(30,41,59,0.08)] hover:border-(--color-terra) transition-colors cursor-pointer">
                <div class="w-10 h-10 rounded-lg bg-[rgba(0,150,136,0.1)] flex items-center justify-center text-xl">📱</div>
                <div>
                    <span class="text-sm font-semibold block">M-Pesa</span>
                    <span class="text-xs text-[rgba(30,41,59,0.5)]">Mobile Money</span>
                </div>
            </div>
            <div class="flex items-center gap-3 p-3 rounded-xl bg-[rgba(255,255,255,0.6)] border border-[rgba(30,41,59,0.08)] hover:border-(--color-terra) transition-colors cursor-pointer">
                <div class="w-10 h-10 rounded-lg bg-[rgba(244,67,54,0.1)] flex items-center justify-center text-xl">📱</div>
                <div>
                    <span class="text-sm font-semibold block">Airtel</span>
                    <span class="text-xs text-[rgba(30,41,59,0.5)]">Mobile Money</span>
                </div>
            </div>
            <div class="flex items-center gap-3 p-3 rounded-xl bg-[rgba(255,255,255,0.6)] border border-[rgba(30,41,59,0.08)] hover:border-(--color-terra) transition-colors cursor-pointer">
                <div class="w-10 h-10 rounded-lg bg-[rgba(33,150,243,0.1)] flex items-center justify-center text-xl">📱</div>
                <div>
                    <span class="text-sm font-semibold block">Tigo Pesa</span>
                    <span class="text-xs text-[rgba(30,41,59,0.5)]">Mobile Money</span>
                </div>
            </div>
            <div class="flex items-center gap-3 p-3 rounded-xl bg-[rgba(255,255,255,0.6)] border border-[rgba(30,41,59,0.08)] hover:border-(--color-terra) transition-colors cursor-pointer">
                <div class="w-10 h-10 rounded-lg bg-[rgba(103,58,183,0.1)] flex items-center justify-center text-xl">💳</div>
                <div>
                    <span class="text-sm font-semibold block">Card</span>
                    <span class="text-xs text-[rgba(30,41,59,0.5)]">Visa/Mastercard</span>
                </div>
            </div>
        </div>
    </div>
</div>
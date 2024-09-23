<form action="{{ route('payment.process', ['id' => $reservation->id]) }}" method="POST">
    @csrf
    <script
        src="https://checkout.stripe.com/checkout.js" class="stripe-button"
        data-key="{{ env('STRIPE_KEY') }}"
        data-amount="{{ $reservation->total_price * 100 }}"
        data-name="Reservation Payment"
        data-description="Payment for Reservation {{ $reservation->reservation_number }}"
        data-currency="usd">
    </script>
</form>

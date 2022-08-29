<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

           <!-- Styles -->
           <link rel="stylesheet" href="{{ asset('css/app.css') }}">

           <!-- Scripts -->
           <script src="{{ asset('js/app.js') }}" defer></script>

           <script src="https://www.paypal.com/sdk/js?client-id=test&currency=USD"></script>

           <script>
            // Render the PayPal button into #paypal-button-container
            paypal.Buttons({

                // Set up the transaction
                createOrder: function(data, actions) {
                    return actions.order.create({
                        purchase_units: [{
                            amount: {
                                value: '88.44'
                            }
                        }]
                    });
                },

                // Finalize the transaction
                onApprove: function(data, actions) {
                    return actions.order.capture().then(function(orderData) {
                        // Successful capture! For demo purposes:
                        console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
                        var transaction = orderData.purchase_units[0].payments.captures[0];
                        alert('Transaction '+ transaction.status + ': ' + transaction.id + '\n\nSee console for all available details');

                        // Replace the above to show a success message within this page, e.g.
                        // const element = document.getElementById('paypal-button-container');
                        // element.innerHTML = '';
                        // element.innerHTML = '<h3>Thank you for your payment!</h3>';
                        // Or go to another URL:  actions.redirect('thank_you.html');
                    });
                }


            }).render('#paypal-button-container');
        </script>


    </head>
    <body class="font-sans antialiased">
        <x-jet-banner />

        <div class="min-h-screen bg-gray-100">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        @stack('modals')

        @livewireScripts
    </body>
</html>

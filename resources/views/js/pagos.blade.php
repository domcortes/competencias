<script src="https://sdk.mercadopago.com/js/v2"></script>
<script>
    $('#categoria').on('change', function(){
        evaluate();
    });

    $('#team_name').on('change', function(){
        evaluate();
    });

    $('#paymentMethod').on('change', function (){
        evaluate();
    });

    function evaluate(){
        toastr.info('Estamos procesando los datos para generar el boton de pago... por favor espere...');

        let category = $('#categoria');
        let team_name = $('#team_name').val();
        let payment_method = $('#paymentMethod').val();

        console.log(payment_method)
        switch(payment_method){
            case 'mercadopago':
                mercadoPagoButton(category.val(), category.attr('identification'), team_name);
                break;

            case 'paypal':
                paypalButton(category.val(), category.attr('identification'), team_name);
                break;

            default:
                console.log('sin medios de pago seleccionado');
        }
    }

    function mercadoPagoButton (category, identification, team_name) {
        let container = document.getElementById('cho-container').innerHTML = '';

        let url = '{{ route('ajax.mercado_pago') }}';
        let data = {
            _token: '{{ csrf_token() }}',
            competition : identification,
            category: category,
            team_name: team_name
        }

        $.post(url, data)
            .done(function(response){
                if(response.result){
                    const mp = new MercadoPago("{{ env('MERCADOPAGO_KEY') }}", {
                        locale: response.currency
                    });

                    mp.checkout({
                        preference: {
                            id: response.preference_id
                        },
                        render: {
                            container: '.cho-container',
                            label: 'Pagar con MercadoPago $' + response.amount + ' ' + response.currency,
                        }
                    });
                } else {
                    toastr.error(response.message);
                }
            })
    }

    function paypalButton(category, competition, team_name) {
        let container = document.getElementById('cho-container');
        container.innerHTML = ''
        let url = '{{ route('ajax.paypal') }}';
        let data = {
            _token: '{{ csrf_token() }}',
            competition : competition,
            category: category,
            team_name: team_name
        }

        $.post(url, data)
            .done(function(response){
                if(response.result){
                    container.innerHTML = '<a class="btn btn-dark" href="'+ response.url +'">Pagar con Paypal</a>'
                } else {
                    toastr.error(response.message);
                }
            })
    }
</script>

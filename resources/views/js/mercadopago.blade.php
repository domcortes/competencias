<script src="https://sdk.mercadopago.com/js/v2"></script>
<script>
    $('#categoria').on('change', function(){
        let category = $('#categoria').val();
        let team_name = $('#team_name').val()
        mercadoPagoButton(category, team_name);
    });

    $('#team_name').on('change', function(){
        let category = $('#categoria').val();
        let team_name = $('#team_name').val()
        mercadoPagoButton(category, team_name);
    });

    function mercadoPagoButton (category, team_name) {
        toastr.info('Estamos procesando los datos para generar el boton de pago... por favor espere...');

        let container = document.getElementById('cho-container').innerHTML = '';

        let url = '{{ route('ajax.mercado_pago') }}';
        let data = {
            _token: '{{ csrf_token() }}',
            competition : $(this).attr('nombre_competencia'),
            identification: $(this).attr('identification'),
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
</script>
